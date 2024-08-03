<?php

namespace App\Livewire;

use App\Models\Recipe as ModelsRecipe;
use Livewire\Attributes\Computed;
use Livewire\Component;
use IvoPetkov\HTML5DOMDocument;
use Illuminate\Support\Str;

class Recipe extends Component
{

    public $recipe;
    public $recipe_title;
    public $title;

    private function getParagraphs($data_test_id)
    {
        $document = new HTML5DOMDocument();
        $document->loadHTML($this->recipe->content, HTML5DOMDocument::ALLOW_DUPLICATE_IDS);

        // Initialize an empty collection
        $items = collect();

        // Find all DIVs with data-test-id="ingredient-item-shipped"
        $divs = $document->querySelectorAll('[data-test-id="' . $data_test_id . '"]');

        foreach ($divs as $div) {
            // Find the img tag and get its src attribute
            $img = $div->querySelector('img');
            $imgSrc = $img ? $img->getAttribute('src') : '';

            // Find all P tags within the current div
            $ps = $div->querySelectorAll('p');

            $textContents = [];
            foreach ($ps as $index => $p) {
                if ($index == 2) {
                    continue;
                }

                $textContents[] = trim($this->fixRecipeText($p->textContent));
            }

            // Combine the P tags' text contents
            $combinedText = implode(' ', $textContents);

            // Add to the collection. Done = have you done this step, as things are tappable to mark as done. 
            $items->push(['image' => $imgSrc, 'text' => $combinedText, 'done' => false]);
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
            ' | HelloFresh' => '',
            'TIP:' => '<br /><br />TIP:',
            '•' => "<br /><br />•"
        ];

        foreach ($replacements as $find => $replace) {
            $text = Str::of($text)->replace($find, $replace);
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
