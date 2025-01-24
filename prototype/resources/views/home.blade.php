@extends('layouts.app')

@section('content')
<div class="bg-light">
    <!-- Introduction Section -->
    <div class="py-5">
        <h2 class="text-center fw-bold mb-5">Nos produits</h2>
        <p class="text-center fs-4 mb-5">
            Découvrez notre large gamme de produits de qualité, adaptés à tous vos besoins.
        </p>
    </div>
    
    <!-- Filters Section -->
    <div class="container mb-4">
        <div class="row">
            <!-- Search Filter -->
            <div class="col-md-6">
                <form action="{{ route('products.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Rechercher un produit" value="{{ request()->get('search') }}">
                        <button class="btn btn-success" type="submit">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                    </div>
                </form>
            </div>
            <!-- Sort Filter -->
            <div class="col-md-6 text-end">
                <form action="{{ route('products.index') }}" method="GET">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="">Trier par</option>
                        <option value="price_asc">Prix: Croissant</option>
                        <option value="price_desc">Prix: Décroissant</option>
                        <option value="name">Nom</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <!-- Product Display Section -->
     <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">  
            @foreach ($products as $product)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm rounded-lg overflow-hidden transition-transform transform hover:-translate-y-2 hover:shadow-2xl duration-300">
                    <!-- Product Image -->
                    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
                        <img src="https://fakeimg.pl/250x250/?text={{ urlencode(explode(' ', $product->name)[0] . ' ' . explode(' ', $product->name)[count(explode(' ', $product->name)) - 1]) }}&font=arial" class="card-img-top object-cover w-full h-56" alt="Generated Image">
                    </a>
                    
                    <!-- Product Content -->
                  <div class="card-body text-center p-4">
                      <!-- Product Title -->
                      <h3 class="card-title fs-4 fw-bold text-dark mb-1">{{ $product->name }}</h3>

                      <!-- Product Description -->
                      <p class="card-text   text-muted mb-1">
                          {{ Str::limit($product->description, 100) }}
                      </p>

                      <!-- Product Price -->
                      <p class="card-text fs-5 fw-bold text-success mb-2">{{ $product->price }} MAD</p>

                      <!-- View More Button -->
                      <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">Voir plus</a>
                  </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Pagination Section -->
    <div class="container mt-4 text-center">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>

    <!-- Testimonials Section -->
    <div class="container py-5 bg-white">
        <h3 class="text-center mb-4">Ce que nos clients disent</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                        <p class="fs-5 text-muted">"Un service excellent, des produits de grande qualité. Je recommande vivement!"</p>
                        <p class="fw-bold">Jean Dupont</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                        <p class="fs-5 text-muted">"La livraison a été rapide et les produits sont bien plus qu'attendus. Très satisfait!"</p>
                        <p class="fw-bold">Marie Martin</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-light shadow-sm">
                    <div class="card-body">
                        <p class="fs-5 text-muted">"Des produits à des prix imbattables. Une expérience d'achat exceptionnelle!"</p>
                        <p class="fw-bold">Sophie Leclerc</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
