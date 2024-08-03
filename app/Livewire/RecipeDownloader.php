<?php

namespace App\Livewire;

use App\Models\Recipe;
use Livewire\Component;
use IvoPetkov\HTML5DOMDocument;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;

class RecipeDownloader extends Component
{

    #[Url]
    public $url = 'https://www.hellofresh.com.au/recipes/golden-haloumi-and-lime-couscous-66849ad89b6d1c18ac617ade';
    public $recipe;
    public $search = 'Test';

    public function deleteAll() {
        Recipe::truncate();
    }

    public function download() {
        if(!$this->url) {
            return;
        }
        $this->recipe = new Recipe;
        $recipe_html = file_get_contents($this->url);

        $document = new HTML5DOMDocument();
        $document->loadHTML($recipe_html, HTML5DOMDocument::ALLOW_DUPLICATE_IDS);

        // Set the title first 
        $title = $document->querySelector('meta[property="og:title"]');
        
        // Then find the description
        $this->recipe->description = $document->querySelector('[data-test-id="description-body-title"]')->textContent;
        $this->recipe->title = Str::of($title->getAttribute('content'))->replace(' | HelloFresh', '');
        $this->recipe->content = $recipe_html;
        $this->recipe->url = $this->url;
        $this->recipe->image_url = $document->querySelector('meta[property="og:image"]')->getAttribute('content');
        
        $this->recipe->save();
        $this->recipe = new Recipe;
        $this->url = '';

    }


    public function render()
    {
        return view('livewire.recipe-downloader');
    }
}
