{{-- This is the main layout. It handles the HTML, head and body tags, and leaves a slot for content --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>{{ $title ?? ''}}</title>
    <script>
        window.onload = () => {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        }
    </script>
    <style>
        html,body { height:100%; }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">{{ $title ?? 'Recipes'}}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            </div>
            <div class="d-flex">
                <a href="/" class="btn btn-secondary float-end-me-3 ms-3"><i class="bi-list"></i> Recipe List</a>
                <a href="https://www.hellofresh.com.au/recipes/search?q=" class="btn btn-secondary float-end-me-3 ms-3" target="_blank"><i class="bi-search"></i> Search Recipes</a>
                <a href="/download" class="btn btn-primary float-end me-3 ms-3"><i class="bi-cloud-plus-fill"></i> Download Recipe</a>
            </div>
        </div>
    </nav>
    <div class="container-fluid vh-100">
        {{ $slot }}
    </div>
</body>

</html>