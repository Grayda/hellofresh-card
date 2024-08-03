<?php

use App\Livewire\Recipe;
use Illuminate\Support\Facades\Route;
use App\Livewire\RecipeDownloader;
use App\Livewire\RecipeList;

Route::get('/', RecipeList::class);
Route::get('/download', RecipeDownloader::class);
Route::get('/recipes/{id}', Recipe::class);