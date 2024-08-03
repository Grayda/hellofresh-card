<div>
    <form wire:submit="download">
        <div class="form-group">
            <label for="url" class="form-label">URL of recipe</label>
            <input type="url" wire:model="url" class="form-control form-control-lg"
                placeholder="https://hellofresh.com.au/...">
            <button type="submit" class="btn btn-lg btn-success mt-3" wire:click="download"><i
                    class="bi-cloud-plus-fill"></i> Download</button>
        </div>
    </form>
    <div wire:loading>
        Working..
    </div>
    <hr />

    <button class="btn btn-danger" wire:confirm="Are you sure you want to do this?" wire:click="deleteAll"><i
            class="trash-fill"></i> Delete All Recipes</button>

</div>