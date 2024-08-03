<div class="container">
    <div class="row">
        @foreach($recipes as $recipe)
        <div class="col-3">
            <div class="card">
                <img src="{{ $recipe->image_url }}" class="card-img-top img-fluid">
                <div class="card-body">
                    <h5 class="card-title">{{ $recipe->title }}</h5>
                    <p class="card-text">{{ $recipe->description }}</p>
                    <p class="card-text"><small class="text-body-secondary">{{ $recipe->created_at->diffForHumans() }}</small></p>
                    <a href="/recipes/{{ $recipe->id }}" class="btn btn-primary stretched-link">View Recipe</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>