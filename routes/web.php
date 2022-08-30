<?php

use App\Http\Controllers\IdeaController;
use App\Http\Livewire\IdeasList;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', IdeasList::class)->name('idea.index');

Route::get('/ideas/{idea:slug}', [IdeaController::class, 'show'])->name('idea.show');

Route::get('/idea', function () {
    return view('idea');
});

require __DIR__.'/auth.php';
