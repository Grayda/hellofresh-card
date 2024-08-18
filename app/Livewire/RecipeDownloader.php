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
    public $url = '';
    
    #[Url]
    public $download = 0; // If this is set to 1, download() is called on page load
    public $recipe;
    public $search = 'Test';

    public function deleteAll() {
        Recipe::truncate();
    }

    public function downloadRecipe() {
        if(!$this->url) {
            return;
        }

        // Fix the URL if it doesn't have http at the start
        if(!Str::of($this->url)->startsWith('http')) {
            $this->url = 'https://' . $this->url;
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
        $this->recipe->content = $document->querySelector('[data-test-id="universal-layout"]');
        $this->recipe->url = $this->url;
        $this->recipe->image_url = $document->querySelector('meta[property="og:image"]')->getAttribute('content');
        
        $this->recipe->save();
        $this->recipe = new Recipe;
        $this->url = '';

    }

    public function mount() {
        // If download = 1 and there's a URL, just download immediately
        if($this->download == '1' && $this->url) {
            $this->downloadRecipe();
            $this->redirect('/');
        }
    }

    public function render()
    {
        return view('livewire.recipe-downloader');
    }
}
