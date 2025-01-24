@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">Liste des produits</h3>
        <div class="ml-auto text-right">
            <a href="{{ route('products.create') }}" class="btn btn-success btn-sm" id="addProduct">
                <i class="fas fa-plus-circle"></i> Ajouter un produit
            </a>
        </div>
    </div>
    <!-- /.card-header -->

    <div class="card-body">
        <table id="productsTable" class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr id="product-{{ $product->id }}">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }} DH</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm mx-1" title="Modifier">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <button type="button" class="btn btn-danger btn-sm mx-1 btnDelete" data-id="{{ $product->id }}" title="Supprimer">
                                <i class="fas fa-trash-alt"></i> Supprimer
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center mt-3">
            {{ $products->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
    <!-- /.card-body -->
</div>

@endsection

@section('script')
<script>
$(document).ready(function () {
    // Add Product
    $(document).on('click', '#addProduct', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        $.ajax({
            type: "GET",
            url: url,
            success: function (response) {
                bootbox.dialog({
                    title: "Créer un nouveau produit",
                    message: response
                });
            },
            error: function () {
                bootbox.alert("Erreur de chargement du formulaire.");
            }
        });
    });

    // Submit Product Form
    $(document).on('submit', '#createProductForm', function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ route('products.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    bootbox.hideAll();
                    $('#productsTable tbody').prepend(`
                        <tr id="product-${response.product.id}">
                            <td>${response.product.id}</td>
                            <td>${response.product.name}</td>
                            <td>${response.product.description}</td>
                            <td>${response.product.price} DH</td>
                            <td class="d-flex justify-content-center">
                                <a href="/products/${response.product.id}/edit" class="btn btn-warning btn-sm mx-1">Modifier</a>
                                <button class="btn btn-danger btn-sm mx-1 btnDelete" data-id="${response.product.id}">Supprimer</button>
                            </td>
                        </tr>
                    `);
                    bootbox.alert("Produit créé avec succès !");
                } else {
                    bootbox.alert("Erreur : Impossible de créer le produit.");
                }
            },
            error: function () {
                bootbox.alert("Erreur lors de la soumission du formulaire.");
            }
        });
    });

$(document).on('click', '.btnDelete', function () {
    let productId = $(this).data('id');
    let url = "{{ route('products.destroy', ':id') }}".replace(':id', productId);

    bootbox.confirm("Voulez-vous vraiment supprimer ce produit ?", function (result) {
        if (result) {
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "DELETE"
                },
                success: function (response) {
                    if (response.success) {
                        // Successfully deleted, remove the row from the table
                        $('#product-' + productId).fadeOut(500, function () {
                            $(this).remove();
                        });
                        bootbox.alert("Produit supprimé avec succès !");
                    } else {
                        // Handle failure, product could not be deleted
                        bootbox.alert(response.message || "Erreur lors de la suppression du produit.");
                    }
                },
                error: function () {
                    bootbox.alert("Erreur lors de la suppression du produit.");
                }
            });
        }
    });
});
});
</script>
@endsection
