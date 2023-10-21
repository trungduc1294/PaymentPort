<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\AudienceController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\AuthorController;
use App\Livewire\Counter;
use App\Livewire\RegistrationManage;
use App\Http\Controllers\ManageRegistrationController;
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
    return view('pages.audience.check_email_bill');
});

//Audience Route
Route::get('/audience-registration', function () {
    return view('pages.audience.audience_registration_form');
})->name('audience-info-form');

Route::post('/audience-registration', [AudienceController::class, 'storeUser']);

Route::get('/audience-purchase', function () {
    return view('pages.audience.audience_purchase_confirm');
})->name('audience-purchase-form');

Route::get('/audience-verify-registration/{id}', [MailController::class, 'audienceVerifyRegistration']);
Route::delete('/audience_delete_registration/{id}', [AudienceController::class, 'deleteRegistration']);
Route::get('/audience-accept-order/{order_id}', [AudienceController::class, 'audienceAcceptOrder'])->name('audience.order.accept');


//Author Route
//Route::get('/author-registration', function () {
//    return view('pages.author.author_search_form');
//});
Route::get('/author-show-posts', [AuthorController::class, 'renderPosts']);
Route::get('/author-info', [AuthorController::class, 'handleAuthorInfo']);
//Route::get('/author-accept-order/{order_id}', [AuthorController::class, 'authorAcceptOrder'])->name('author.order.accept'); //cai nay dung
Route::get('/author-accept-order', [AuthorController::class, 'authorAcceptOrder'])->name('author.order.accept');


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



//test route
Route::get('/test-mail', [MailController::class, 'testMail']);
Route::get('/counter', Counter::class);
Route::get('/posts', function () {
    return view('search_test');
});
