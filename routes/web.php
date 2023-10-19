<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\AudienceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.homepage');
});

Route::get('/test', function () {
    return view('pages.homepage');
});

//Audience Route
Route::get('/audience-registration', function () {
    return view('pages.audience.audience_registration_form');
})->name('audience-info-form');

Route::post('/audience-registration', [AudienceController::class, 'storeUser']);

Route::get('/audience-purchase', function () {
    return view('pages.audience.audience_purchase_confirm');
})->name('audience-purchase-form');



//Author Route
Route::get('/author-registration', function () {
    return view('pages.author.author_search_form');
});


// import route
Route::get('/import-excel', function () {
    return view('import');
});
Route::post('/import-excel', [ImportExcelController::class, 'importExcel']);
