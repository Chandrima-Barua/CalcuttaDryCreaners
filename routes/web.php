<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::post('storetoken', 'Auth\RegisterController@storetoken')->name('storetoken');
// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::post('/save-device-token', 'HomeController@saveToken');
Route::post('/send-push', 'HomeController@sendPush')->name('send-push');
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::prefix('services')->group(function () {
    Route::get('/', 'ServiceController@index')->name('services.index')->middleware('auth');
    Route::get('/create', 'ServiceController@create')->name('services.create')->middleware('auth');
    Route::post('/services', 'ServiceController@store')->name('services.store')->middleware('auth');
    Route::get('/show/{id}', 'ServiceController@show')->name('services.show')->middleware('auth');
    Route::get('/edit/{id}', 'ServiceController@edit')->name('services.edit')->middleware('auth');
    Route::post('/edit/{id}', 'ServiceController@update')->name('services.update')->middleware('auth');
    Route::get('/delete/{id}', 'ServiceController@destroy')->name('services.destroy')->middleware('auth');
});

Route::prefix('itemtype')->group(function () {
    Route::get('/', 'ItemTypeController@index')->name('itemtype.index')->middleware('auth');
    Route::get('/create', 'ItemTypeController@create')->name('itemtype.create')->middleware('auth');
    Route::post('/itemtype', 'ItemTypeController@store')->name('itemtype.store')->middleware('auth');
    Route::get('/show/{id}', 'ItemTypeController@show')->name('itemtype.show')->middleware('auth');
    Route::get('/edit/{id}', 'ItemTypeController@edit')->name('itemtype.edit')->middleware('auth');
    Route::post('/edit/{id}', 'ItemTypeController@update')->name('itemtype.update')->middleware('auth');
    Route::get('/delete/{id}', 'ItemTypeController@destroy')->name('itemtype.destroy')->middleware('auth');
});

Route::prefix('items')->group(function () {
    Route::get('/', 'ItemController@index')->name('items.index')->middleware('auth');
    Route::get('/create', 'ItemController@create')->name('items.create')->middleware('auth');
    Route::post('/items', 'ItemController@store')->name('items.store')->middleware('auth');
    Route::get('/show/{id}', 'ItemController@show')->name('items.show')->middleware('auth');
    Route::get('/edit/{id}', 'ItemController@edit')->name('items.edit')->middleware('auth');
    Route::post('/edit/{id}', 'ItemController@update')->name('items.update')->middleware('auth');
    Route::get('/delete/{id}', 'ItemController@destroy')->name('items.destroy')->middleware('auth');
});

Route::prefix('invoice')->group(function () {
    Route::get('/', 'InvoiceController@index')->name('invoice.index')->middleware('auth');
    Route::get('/create', 'InvoiceController@create')->name('invoice.create')->middleware('auth');
    Route::post('/invoice', 'InvoiceController@store')->name('invoice.store')->middleware('auth');
    Route::get('/show/{id}', 'InvoiceController@show')->name('invoice.show')->middleware('auth');
    Route::get('/edit/{id}', 'InvoiceController@edit')->name('invoice.edit')->middleware('auth');
    Route::post('/edit/{id}', 'InvoiceController@update')->name('invoice.update')->middleware('auth');
    Route::get('/delete/{id}', 'InvoiceController@destroy')->name('invoice.destroy')->middleware('auth');
    Route::get('/pdf/{invoice_id}', 'InvoiceController@pdfview')->name('invoice.pdf')->middleware('auth');
    Route::get('/pdfdata/{invoice_id}', 'InvoiceController@pdfdata')->name('invoice.pdfdata')->middleware('auth');
    Route::get('/exportCSV', 'InvoiceController@exportCSV')->name('invoice.csv');
    Route::get('/template', 'InvoiceController@template')->name('invoice.template');
});
// Order Status Route
Route::prefix('orderstatuses')->group(function () {
    Route::get('/', 'OrderstatusController@index')->name('orderstatus.index')->middleware('auth');
    Route::get('/new', 'OrderstatusController@create')->name('orderstatus.create')->middleware('auth');
    Route::post('/new', 'OrderstatusController@store')->name('orderstatus.store')->middleware('auth');
    Route::get('/show/{id}', 'OrderstatusController@show')->name('orderstatus.show')->middleware('auth');
    Route::get('/edit/{id}', 'OrderstatusController@edit')->name('orderstatus.edit')->middleware('auth');
    Route::get('/makedefault/{id}', 'OrderstatusController@makedefault')->name('orderstatus.makedefault')->middleware('auth');
    Route::post('/edit/{id}', 'OrderstatusController@update')->name('orderstatus.update')->middleware('auth');
    Route::get('/delete/{id}', 'OrderstatusController@destroy')->name('orderstatus.destroy')->middleware('auth');
});
// Route::prefix('orders')->group(function () {
// Route::get('/corporate/new', 'OrdersController@corporatecreate')->name('corporateCreate')->middleware('auth');
//     Route::get('/corporate/new', 'OrdersController@store')->name('orders.corporate_store')->middleware('auth');
// });

Route::prefix('orders')->group(function () {
    Route::get('/', 'OrdersController@index')->name('orders.index')->middleware('auth');
    Route::get('/new', 'OrdersController@create')->name('orders.create')->middleware('auth');
    Route::post('/new', 'OrdersController@store')->name('orders.store')->middleware('auth');
    Route::get('/corporate/new', 'OrdersController@create')->name('corporateCreate')->middleware('auth');
    Route::post('/corporate/new', 'OrdersController@store')->name('orders.corporateStore')->middleware('auth');
    Route::get('/show/{id}', 'OrdersController@show')->name('orders.show')->middleware('auth');
    Route::get('/edit/{id}', 'OrdersController@edit')->name('orders.edit')->middleware('auth');
    Route::post('/edit/{id}', 'OrdersController@update')->name('orders.update')->middleware('auth');
    Route::get('/delete/{id}', 'OrdersController@destroy')->name('orders.destroy')->middleware('auth');
    Route::get('/edit/items/{id}', 'OrdersController@getItems')->name('orders.edit.getitems')->middleware('auth');
    Route::get('/edit/cart/{id}', 'OrdersController@getCarts')->name('orders.getcarts')->middleware('auth');
    Route::get('/items/{serviceid}/{slug}', 'OrdersController@getItems')->name('orders.getitems')->middleware('auth');
    Route::get('/invoice/create/{id}', 'InvoiceController@orderinvoice')->name('orders.invoice.create')->middleware('auth');
    Route::get('/services/{slug}', 'OrdersController@getServices')->name('orders.getservices')->middleware('auth');
    Route::get('/corporate/services/{slug}', 'OrdersController@getServices')->name('orders.corpogetServices')->middleware('auth');
    Route::get('/items/{code}', 'OrdersController@searchitems')->name('orders.searchitems')->middleware('auth');
    Route::get('/corporate/items/{code}', 'OrdersController@searchitems')->name('orders.corposearchitems')->middleware('auth');
    Route::Post('/orderstatus/{id}', 'OrdersController@updatestatus')->name('orders.updatestatus')->middleware('auth');
    Route::get('/branch/{id}', 'OrdersController@getbranch')->name('orders.getbranch')->middleware('auth');
    Route::get('/corporate/branch/{id}', 'OrdersController@getbranch')->name('orders.corpogetbranch')->middleware('auth');
    Route::Post('/orderstatusPush', 'OrdersController@orderstatusPush')->name('orders.orderstatusPush')->middleware('auth');
});

Route::prefix('profile')->group(function () {
    Route::get('/', 'ProfileController@index')->name('user.profile')->middleware('auth');
    Route::post('/edit', 'ProfileController@update')->name('user.profile.update')->middleware('auth');
    Route::get('/delete/{id}', 'ProfileController@destroy')->name('user.profile.destroy')->middleware('auth');
});

Route::prefix('roles')->group(function () {
    Route::get('/', 'RoleController@index')->name('roles.index')->middleware('auth');
    Route::get('/create', 'RoleController@create')->name('roles.create')->middleware('auth');
    Route::post('/services', 'RoleController@store')->name('roles.store')->middleware('auth');
    Route::get('/show/{id}', 'RoleController@show')->name('roles.show')->middleware('auth');
    Route::get('/edit/{id}', 'RoleController@edit')->name('roles.edit')->middleware('auth');
    Route::post('/edit/{id}', 'RoleController@update')->name('roles.update')->middleware('auth');
    Route::get('/delete/{id}', 'RoleController@destroy')->name('roles.destroy')->middleware('auth');
});

Route::prefix('users')->group(function () {
    Route::get('/', 'RoleController@userlist')->name('users.index')->middleware('auth');
    Route::get('/edit/{id}', 'RoleController@user_role_edit')->name('users.edit')->middleware('auth');
    Route::post('/edit/{id}', 'RoleController@user_role_update')->name('users.update')->middleware('auth');
    Route::get('/delete/{id}', 'RoleController@destroy')->name('users.destroy')->middleware('auth');
});

Route::prefix('branches')->group(function () {
    Route::get('/', 'BranchController@index')->name('branch.index')->middleware('auth');
    Route::get('/create', 'BranchController@create')->name('branch.create')->middleware('auth');
    Route::post('/branches', 'BranchController@store')->name('branch.store')->middleware('auth');
    Route::get('/show/{id}', 'BranchController@show')->name('branch.show')->middleware('auth');
    Route::get('/edit/{id}', 'BranchController@edit')->name('branch.edit')->middleware('auth');
    Route::post('/edit/{id}', 'BranchController@update')->name('branch.update')->middleware('auth');
    Route::get('/delete/{id}', 'BranchController@destroy')->name('branch.destroy')->middleware('auth');
});

Route::get('/attendance', 'BiometricController@biometric')->name('attendance')->middleware('auth');
Route::get('/expense_reports', 'StaffExpenseController@index')->name('staffexpense.report')->middleware('auth');
Route::get('/expense_reports/search', 'StaffExpenseController@search')->name('staffexpense.search')->middleware('auth');

Route::prefix('expense_categories')->group(function () {
    Route::get('/', 'ExpenseCategoriesController@index')->name('expense_categories.index')->middleware('auth');
    Route::get('/create', 'ExpenseCategoriesController@create')->name('expense_categories.create')->middleware('auth');
    Route::post('/expense_categories', 'ExpenseCategoriesController@store')->name('expense_categories.store')->middleware('auth');
    Route::get('/show/{id}', 'ExpenseCategoriesController@show')->name('expense_categories.show')->middleware('auth');
    Route::get('/edit/{id}', 'ExpenseCategoriesController@edit')->name('expense_categories.edit')->middleware('auth');
    Route::post('/edit/{id}', 'ExpenseCategoriesController@update')->name('expense_categories.update')->middleware('auth');
    Route::get('/delete/{id}', 'ExpenseCategoriesController@destroy')->name('expense_categories.destroy')->middleware('auth');
});

Route::prefix('expenses')->group(function () {
    Route::get('/', 'ExpenseController@index')->name('expense.index')->middleware('auth');
    Route::get('/create', 'ExpenseController@create')->name('expense.create')->middleware('auth');
    Route::post('/expenses', 'ExpenseController@store')->name('expense.store')->middleware('auth');
    Route::get('/show/{id}', 'ExpenseController@show')->name('expense.show')->middleware('auth');
    Route::get('/edit/{id}', 'ExpenseController@edit')->name('expense.edit')->middleware('auth');
    Route::post('/edit/{id}', 'ExpenseController@update')->name('expense.update')->middleware('auth');
    Route::get('/delete/{id}', 'ExpenseController@destroy')->name('expense.destroy')->middleware('auth');
});

Route::prefix('legal_categories')->group(function () {
    Route::get('/', 'LegalCategoriesController@index')->name('legal_categories.index')->middleware('auth');
    Route::get('/create', 'LegalCategoriesController@create')->name('legal_categories.create')->middleware('auth');
    Route::post('/expenses', 'LegalCategoriesController@store')->name('legal_categories.store')->middleware('auth');
    Route::get('/show/{id}', 'LegalCategoriesController@show')->name('legal_categories.show')->middleware('auth');
    Route::get('/edit/{id}', 'LegalCategoriesController@edit')->name('legal_categories.edit')->middleware('auth');
    Route::post('/edit/{id}', 'LegalCategoriesController@update')->name('legal_categories.update')->middleware('auth');
    Route::get('/delete/{id}', 'LegalCategoriesController@destroy')->name('legal_categories.destroy')->middleware('auth');
});

Route::prefix('legal_documents')->group(function () {
    Route::get('/', 'LegalDocumentsController@index')->name('legal_documents.index')->middleware('auth');
    Route::get('/create', 'LegalDocumentsController@create')->name('legal_documents.create')->middleware('auth');
    Route::post('/expenses', 'LegalDocumentsController@store')->name('legal_documents.store')->middleware('auth');
    Route::get('/show/{id}', 'LegalDocumentsController@show')->name('legal_documents.show')->middleware('auth');
    Route::get('/edit/{id}', 'LegalDocumentsController@edit')->name('legal_documents.edit')->middleware('auth');
    Route::post('/edit/{id}', 'LegalDocumentsController@update')->name('legal_documents.update')->middleware('auth');
    Route::get('/delete/{id}', 'LegalDocumentsController@destroy')->name('legal_documents.destroy')->middleware('auth');
    Route::get('/notification/{id}', 'LegalDocumentsController@send_notification')->name('legal_documents.notification')->middleware('auth');
    Route::post('/set_deadline', 'LegalDocumentsController@set_deadline')->name('legal_documents.set_deadline')->middleware('auth');
});

Route::get('/markAsRead', function () {
    auth()->user()->unreadNotifications->markAsRead();

    return redirect()->back();
})->name('mark');

Route::prefix('notices')->group(function () {
    Route::get('/', 'NoticeController@index')->name('notice.index')->middleware('auth');
    Route::get('/create', 'NoticeController@create')->name('notice.create')->middleware('auth');
    Route::post('/notices', 'NoticeController@store')->name('notice.store')->middleware('auth');
    Route::get('/show/{id}', 'NoticeController@show')->name('notice.show')->middleware('auth');
    Route::get('/edit/{id}', 'NoticeController@edit')->name('notice.edit')->middleware('auth');
    Route::post('/edit/{id}', 'NoticeController@update')->name('notice.update')->middleware('auth');
    Route::get('/delete/{id}', 'NoticeController@destroy')->name('notice.destroy')->middleware('auth');
    Route::post('/notice_read', 'NoticeController@read_notice')->name('notice.read_notice')->middleware('auth');
});
