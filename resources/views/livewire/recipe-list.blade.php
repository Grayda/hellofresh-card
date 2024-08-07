<div class="container">
    <div class="row">
        @forelse($recipes as $recipe)
        <div class="col-3">
            <div class="card">
                <img src="{{ $recipe->image_url }}" class="card-img-top img-fluid">
                <div class="card-body">
                    <h5 class="card-title">{{ $recipe->title }}</h5>
                    <p class="card-text">{{ $recipe->description }}</p>
                    <p class="card-text"><small class="text-body-secondary">{{ $recipe->created_at->diffForHumans() }}</small></p>
                </div>
                <div class="card-footer">
                    <a href="/recipes/{{ $recipe->id }}" class="btn d-block stretched-link">Tap to View Recipe</a>
                </div>
            </div>
        </div>
        @empty
            <div class="text-center">
                <h1>No Recipes have been added yet!</h1>
                <p>Click on "<i class="bi-cloud-plus-fill"></i> Download Recipe" to learn how to download a recipe</p>
            </div>
        @endforelse
    </div>
</div>
</div>