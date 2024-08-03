<?php

namespace App\Livewire;

use App\Models\Recipe;
use Livewire\Component;

class RecipeList extends Component
{

    public $recipes;

    public function boot() {
        $this->recipes = Recipe::all();
    }

    public function render()
    {
        return view('livewire.recipe-list');
    }
}
