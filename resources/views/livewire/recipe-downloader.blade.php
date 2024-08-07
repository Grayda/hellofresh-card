<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-6">
                <h3>Recipe Downloader</h3>
                <form wire:submit="downloadRecipe">

                    <div class="form-group">
                        <label for="url" class="form-label">URL of recipe</label>
                        <input type="url" wire:model="url" class="form-control form-control-lg"
                            placeholder="https://hellofresh.com.au/recipes/...">
                        <button type="submit" class="btn btn-lg btn-success mt-3" wire:click="download"><i
                                class="bi-cloud-plus-fill"></i> Download</button>
                    </div>
                    <div class="alert alert-success" wire:loading>
                        <i class="bi-cloud-arrow-down-fill"></i> Downloading..
                    </div>
                </form>
            </div>
            <div class="col-6">
                <h3>How to use</h3>
                <ol>
                    <li>If you haven't already, drag this bookmark to your bookmark bar: <a
                            href="javascript:!function(){function t(t){var o=document.querySelector(t);return!!o&&(o.click(),!0)}t('button[data-test-id=&quot;share-button&quot;]')?setTimeout((function(){t(%27button[data-test-id=&quot;copy-link-button&quot;]%27)?setTimeout((function(){navigator.clipboard.readText().then((function(t){window.open(&quot;{{ env('APP_URL') }}/download?download=1&url=&quot;+encodeURIComponent(t),&quot;_blank&quot;)})).catch((function(t){console.error(&quot;Failed to read from clipboard:&quot;,t)}))}),100):alert(&quot;Copy link button not found.&quot;)}),1e3):alert(&quot;Share button not found.&quot;)}();">Download
                            Recipe</a></li>
                    <li>Go to the <a href="https://www.hellofresh.com.au/my-account/deliveries/menu">Deliveries</a> page</li>
                    <li>Find the recipe you want to save and click on it</li>
                    <li>Click on the "Download Recipe" bookmark</li>
                    <li>A new tab will open and the recipe will download</li>
                    <li>You'll be taken back to the recipe list, and you'll see the newly downloaded recipe</li>
                </ol>

                <h3>Removing all old recipes</h3>
                <p>To remove all the recipes and start again, click on the button below</p>
                <button class="btn btn-danger" wire:confirm="Are you sure you want to do this?"
                    wire:click="deleteAll"><i class="trash-fill"></i> Delete All Recipes</button>
            </div>
        </div>
    </div>
</div>