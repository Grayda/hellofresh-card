<?php

namespace App\Livewire;

use App\Models\Recipe as ModelsRecipe;
use Livewire\Attributes\Computed;
use Livewire\Component;
use IvoPetkov\HTML5DOMDocument;

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
    
    public function deleteRecipe() {
        $this->recipe->delete();
        $this->redirect('/');
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
                    $smallerText[] = trim($this->fixRecipeText($p->getTextContent()));
                    continue;
                }

                $textContents[] = trim($this->fixRecipeText($p->getTextContent()));
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
            '/ \| HelloFresh/i' => '', // Find the | HelloFresh header which is present at the end of the page title or metadata, and remove it
            '/TIP: (.*)/i' => '<div class="alert alert-info mt-3"><i class="bi-info-circle-fill"></i> TIP: $1</div>', // Turns the TIP: box into a bootstrap alert
            '/Little cooks: (.*)/i' => '<div class="alert alert-dark mt-3"><i class="bi bi-person-arms-up"></i> Little cooks: $1</div>', // Same thing, but with the Little Cooks text
            '/•/i' => '<br /><br />•', // Finds the bulletpoints which are on the same line for some reason, and put them all on their own line for readability
            '/(?<!last )(\d{1,2})(?:-|—)?\d{0,2}(?= minutes?)/i' => '<a class="btn btn-success" onclick="window.setCookingTimer($1)" href="javascript:void(0)"><i class="bi bi-stopwatch-fill"></i> $1 minutes</a>' // Finds all the times (e.g. '20-25 minutes' and converts them into clickable timer links
        ];

        // Loop through all the replacements in the recipe step and fix them up
        foreach ($replacements as $find => $replace) {
            $text = preg_replace($find, $replace, $text);
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
