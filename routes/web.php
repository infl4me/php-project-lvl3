<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\DB;
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

Route::get('/', function () {
    $items = DB::select("SELECT * FROM test");
    return view('welcome', compact('items'));
})->name('/');

Route::get('urls', [UrlController::class, 'index'])
    ->name('urls.index');
Route::post('urls', [UrlController::class, 'store'])
    ->name('urls.store');
