<div class="card card-info" id="createProduct">
    <div class="card-header bg-info text-white">
        <h3 class="card-title">Ajouter un nouveau produit</h3>
    </div>
    <form action="{{ route('products.store') }}" method="POST" aria-labelledby="createProduct">
        @csrf <!-- Protection contre les attaques CSRF -->
        <div class="card-body">
            <!-- Nom du produit -->
            <div class="form-group">
                <label for="name" class="form-label">Nom du produit</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="form-control" 
                    placeholder="Nom unique du produit (ex: T-shirt rouge)" 
                    required 
                    aria-describedby="nameHelp">
            </div>
            
            <!-- Description -->
            <div class="form-group">
                <label for="description" class="form-label">Description du produit</label>
                <textarea 
                    name="description" 
                    id="description" 
                    class="form-control" 
                    rows="3" 
                    placeholder="Décrivez brièvement le produit et ses caractéristiques" 
                    required 
                    aria-describedby="descriptionHelp"></textarea>
            </div>
            
            <!-- Prix -->
            <div class="form-group">
                <label for="price" class="form-label">Prix du produit (en DH)</label>
                <input 
                    type="number" 
                    name="price" 
                    id="price" 
                    class="form-control" 
                    placeholder="Entrez le prix en dirhams" 
                    step="0.01" 
                    required 
                    min="0" 
                    aria-describedby="priceHelp">
            </div>
        </div>

        <!-- Footer with action buttons -->
        <div class="card-footer d-flex justify-content-between">
            <button type="submit" class="btn btn-success">Ajouter le produit</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
