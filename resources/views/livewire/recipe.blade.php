<div>
    <p>{{ $this->recipe_description[0]['text'] }}</p>

    <h2>Ingredients</h2>
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach($this->recipe_ingredients as $index => $ingredient)
                <div class="col">
                    <div class="card h-100 text-bg-{{ $ingredient['done'] == true ? 'success' : 'secondary' }} mb-3" wire:click="markDone($index)">
                        @if($ingredient['image'])
                            <img src="{{ $ingredient['image'] }}" class="card-img-top" alt="...">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $ingredient['text'] }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
                @foreach($this->pantry_ingredients as $index => $ingredient)
                <div class="col">
                    <div class="card h-100 text-bg-{{ $ingredient['done'] == true ? 'success' : 'secondary' }} mb-3" wire:click="markDone($index)">
                        @if($ingredient['image'])
                            <img src="{{ $ingredient['image'] }}" class="card-img-top" alt="...">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $ingredient['text'] }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
    <hr />
    <h2>Steps</h2>
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach($this->recipe_steps as $index => $step)
                <div class="col">
                    <div class="card h-100">
                        @if($step['image'])
                            <img src="{{ $step['image'] }}" class="card-img-top" alt="...">
                        @endif
                        <div class="card-header">Step {{ $index + 1 }}</div>
                        <div class="card-body">
                            <h5 class="card-title">{!! $step['text'] !!}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
</div>

@script
<script>



</script>
@endscript