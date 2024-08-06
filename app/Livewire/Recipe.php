<?php

namespace App\Livewire;

use App\Models\Recipe as ModelsRecipe;
use Livewire\Attributes\Computed;
use Livewire\Component;
use IvoPetkov\HTML5DOMDocument;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;

class Recipe extends Component
{

    public $recipe;
    public $recipe_title;
    public $title;

    public $columns = 2; // How many columns should we show on the page?
    public $images = true; // Set to false to hide images

    public function setColumns($num = 2) {
        $this->columns = $num;
    }

    public function toggleImages() {
        $this->images = !$this->images;
    }

    private function getParagraphs($data_test_id)
    {
        $document = new HTML5DOMDocument();
        $document->loadHTML($this->recipe->content, HTML5DOMDocument::ALLOW_DUPLICATE_IDS);

        // Initialize an empty collection
        $items = collect();

        // Find all DIVs with data-test-id="ingredient-item-shipped"
        $divs = $document->querySelectorAll('[data-test-id="' . $data_test_id . '"]');

        foreach ($divs as $divIndex => $div) {
            // Find the img tag and get its src attribute
            $img = $div->querySelector('img');
            $imgSrc = $img ? $img->getAttribute('src') : '';
            $smallerText = [];

            // Find all P tags within the current div
            $ps = $div->querySelectorAll('p');

            $textContents = [];
            foreach ($ps as $index => $p) {
                if ($index >= 2) {
                    $smallerText[] = trim($this->fixRecipeText($p->textContent));
                    continue;
                }

                $textContents[] = trim($this->fixRecipeText($p->textContent));
            }

            // Combine the P tags' text contents
            $combinedText = implode(' ', $textContents);
            $subtitleText = implode(' ', $smallerText);
            
            // Add to the collection. Done = have you done this step, as things are tappable to mark as done. 
            $items->push(['image' => $imgSrc, 'text' => $combinedText, 'done' => false, 'subtitle' => $subtitleText]);
        }

        // Return the collection
        return $items;
    }

    #[Computed]
    public function recipe_ingredients()
    {
        return $this->getParagraphs('ingredient-item-shipped');
    }

    #[Computed]
    public function pantry_ingredients()
    {
        return $this->getParagraphs('ingredient-item-not-shipped');
    }

    #[Computed]
    public function recipe_steps()
    {
        return $this->getParagraphs('instruction-step');
    }

    #[Computed]
    public function recipe_description()
    {
        return $this->getParagraphs('description-body-title');
    }

    private function fixRecipeText($text)
    {
        $replacements = [
            '/ \| HelloFresh/i' => '',
            '/TIP:/i' => '<br /><br />TIP:',
            '/•/i' => '<br /><br />•',
            '/(\d+) minutes/i' => '$1 minutes (<a onclick="window.setCookingTimer($1)" href="javascript:void(0)">Set Timer</a>)'
        ];

        // $regex, $with, $stringtoreplace

        foreach ($replacements as $find => $replace) {
            $text = preg_replace($find, $replace, $text);
            // $text = Str::of($text)->replace($find, $replace);
        }

        return $text;
    }

    public function mount($id)
    {
        $this->recipe = ModelsRecipe::find($id);
    }

    public function render()
    {
        return view('livewire.recipe')->title($this->recipe->title ?? 'Recipe');
    }
}
