<div>
    <div class="container-fluid">
        <div class="row">
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
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <button class="btn btn-danger" wire:confirm="Are you sure you want to do this?" wire:click="deleteAll"><i
                class="trash-fill"></i> Delete All Recipes</button>
        </div>
        
    </div>

    <div class="row">
        <h3>Bookmarks</h3>
        <p>Drag these bookmarks to your bookmark bar to speed up adding of recipes</p>
        <a
            href="javascript:!function(){var o='{{ env('APP_URL') }}/download?url='+encodeURIComponent(window.location.href);window.location.href=o}();">Download
            Recipe Bookmark</a><br />
        <a
            href="javascript:!function(){let e=document.querySelectorAll('[data-test-id=\'recipe-card-title\'']');e.forEach(e=>{let t=e.innerText,l=`https://www.hellofresh.com.au/recipes/search?q=${encodeURIComponent(t)}`;window.open(l,'_blank')})}();">Bulk
            Search Recipes</a>
    </div>






</div>