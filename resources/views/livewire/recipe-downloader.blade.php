<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <h3>Recipe Downloader</h3>
                <form wire:submit="download">
                    <div class="form-group">
                        <label for="url" class="form-label">URL of recipe</label>
                        <input type="url" wire:model="url" class="form-control form-control-lg"
                            placeholder="https://hellofresh.com.au/...">
                        <button type="submit" class="btn btn-lg btn-success mt-3" wire:click="download"><i
                                class="bi-cloud-plus-fill"></i> Download</button>
                    </div>
                </form>
                <div wire:loading class="alert alert-success d-block mt-3">
                    <i class="bi-cloud-arrow-down-fill"></i> Downloading..
                </div>
            </div>
            <div class="col-4">
                <h3>How to use</h3>
                <ol>
                    <li>If you haven't already, drag this bookmark to your bookmark bar: <a
                            href="javascript:!function(){var o='{{ env('APP_URL') }}/download?url='+encodeURIComponent(window.location.href);window.location.href=o}();">Download
                            Recipe</a></li>
                    <li>Click on "<i class="bi-search"></i> Search Recipes" in the top right-hand corner</li>
                    <li>Find the recipe you want and click on it</li>
                    <li>Click on the "Download Recipe" bookmark</li>
                    <li>You will be brought back to this page. Click on "<i class="bi-cloud-plus-fill"></i> Download"
                    </li>
                    <li>You'll see a green bar show up that says "Downloading..". When the bar disappears, the recipe has
                        finished downloading</li>
                    <li>Click on "<i class=""></i> Recipe List" to view it</li>
                    <li>If you want to search for all recipes at the same time, use this bookmark: <a
                            href="javascript:!function(){let e=document.querySelectorAll('[data-test-id=&quot;recipe-card-title&quot;]'); e.forEach(e=>{let t=e.innerText,l=`https://www.hellofresh.com.au/recipes/search?q=${encodeURIComponent(t)}`; window.open(l,'_blank')})}();">Bulk
                            Search Recipes</a></li>
                </ol>
            </div>
            <!-- <div class="col-4">
                <h3>Bookmarks</h3>
                <p>Drag these bookmarks to your bookmark bar to speed up adding of recipes</p>
                <br />
                <a
                    href="javascript:!function(){let e=document.querySelectorAll('[data-test-id=\'recipe-card-title\'']');e.forEach(e=>{let t=e.innerText,l=`https://www.hellofresh.com.au/recipes/search?q=${encodeURIComponent(t)}`;window.open(l,'_blank')})}();">Bulk
                    Search Recipes</a>
            </div> -->
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <button class="btn btn-danger" wire:confirm="Are you sure you want to do this?" wire:click="deleteAll"><i
                    class="trash-fill"></i> Delete All Recipes</button>
        </div>

    </div>

</div>