<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortLinkController;
use App\Http\Middleware\ValidateCodeAndStoreHistory;

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
//Route::redirect('/','list-links');
Route::get('/', [ShortLinkController::class, 'index'])->name('home');
Route::get('generate-link', [ShortLinkController::class, 'create'])->name('create-link');
Route::post('generate-link', [ShortLinkController::class, 'store'])->name('store-link');

Route::get('short/{code}', [ShortLinkController::class, 'view'])->middleware(ValidateCodeAndStoreHistory::class)->name('go-to-page');
