<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportExcelController;
//use App\Http\Controllers\AudienceController;
//use App\Http\Controllers\MailController;
use App\Http\Controllers\AuthorController;
//use App\Livewire\Counter;
use App\Livewire\RegistrationManage;
//use App\Http\Controllers\ManageRegistrationController;
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


//Audience Page Route
Route::get('/audience-registration-page', function () {
    return view('pages.audience.audience_page');
});

//Route::get('/author-show-posts', [AuthorController::class, 'renderPosts']);
//Route::get('/author-info', [AuthorController::class, 'handleAuthorInfo']);
////Route::get('/author-accept-order/{order_id}', [AuthorController::class, 'authorAcceptOrder'])->name('author.order.accept'); //cai nay dung
//Route::get('/author-accept-order', [AuthorController::class, 'authorAcceptOrder'])->name('author.order.accept');

Route::get('/author', function () {
    return view('pages.author.author_search_form');
});


// Registration Manage Route
Route::get('/registration-manage', function () {
    return view('pages.manage-registration.manage_registration');
});

Route::post('/delete-order/{id}', [RegistrationManage::class, 'deleteOrder']);



// import route
Route::get('/import-excel', function () {
    return view('import');
});
Route::post('/import-excel', [ImportExcelController::class, 'importExcel']);


// Test
Route::get('/test-alert', function () {
    return view('pages.test-alert.test-alert');
});
