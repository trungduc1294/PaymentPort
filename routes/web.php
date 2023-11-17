<?php

use App\Http\Controllers\CancelController;
use App\Http\Controllers\PaymentHookController;
use App\Http\Controllers\ReturnController;
use App\Livewire\PaymentPortalCancel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportExcelController;
//use App\Http\Controllers\AudienceController;
//use App\Http\Controllers\MailController;
//use App\Http\Controllers\AuthorController;
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


// Home page =================================================================================================
Route::get('/', function () {
    return redirect('/author');
    // return view('pages.homepage');
});


//Audience Page Route ========================================================================================
Route::get('/audience-registration-page', function () {
    return view('pages.audience.audience_page');
});

// Author Page Route ========================================================================================
Route::get('/author', function () {
    return view('pages.author.author_search_form');
});

// Registration Manage Route =================================================================================
Route::get('/registration-manage', function () {
    return view('pages.manage-registration.manage_registration');
});

Route::post('/delete-order/{id}', [RegistrationManage::class, 'deleteOrder']);






// payment portal route ========================================================================================
Route::any('/payment-notification', [PaymentHookController::class, 'index'])->name('payment.notification');

//Route::get('/payment-cancel', function () {
//    return view('pages.payment-portal.cancel');
//})->name('payment.cancel');

Route::any('/payment-return-view', function () {
    return view('pages.payment-portal.return');
})->name('payment.return-view');

Route::any('/payment-return', [ReturnController::class, 'success'])->name('payment.return');
Route::any('/payment-cancel', [CancelController::class, 'failed'])->name('payment.cancel');


Route::get('/test', function () {
    app(\App\Services\PaymentService::class)->create('BK123456', 100000);
});


// Admin route ========================================================================================
Route::get('/admin/delete-all-posts', function () {
    return view('admin.delete-all-post');
});

Route::get('/admin/get-all-transactions-data', function () {
    return view('admin.get-all-transactions');
});

//import excel file ==========================================================================================
// import export route
Route::get('/import-excel', function () {
    return view('import');
});
Route::post('/import-excel', [ImportExcelController::class, 'importExcel']);

// export excel file
Route::get('/export-excel', [\App\Http\Controllers\ExportExcelController::class, 'export']);

// Maintainance route ========================================================================================
Route::get('/maintain', function () {
    return view('pages.maintain.maintain');
})->name('maintain');
