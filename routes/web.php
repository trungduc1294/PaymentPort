<?php

use App\Http\Controllers\PaymentHookController;
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

//import excel file ==========================================================================================
// import export route
Route::get('/import-excel', function () {
    return view('import');
});
Route::post('/import-excel', [ImportExcelController::class, 'importExcel']);

// export excel file
Route::get('/export-excel', [\App\Http\Controllers\ExportExcelController::class, 'export']);




// payment portal route ========================================================================================
Route::any('/payment-notification', [PaymentHookController::class, 'index'])->name('payment.notification');

Route::get('/payment-cancel', function () {
    return view('pages.payment-portal.cancel');
})->name('payment.cancel');

Route::get('/payment-return', function () {
    return view('pages.payment-portal.return');
})->name('payment.return');


Route::get('/test', function () {
    app(\App\Services\PaymentService::class)->create('BK123456', 100000);
});


// Admin route ========================================================================================
Route::get('/admin/delete-all-posts', function () {
    return view('admin.delete-all-post');
});
