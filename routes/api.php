<?php

use App\Http\Controllers\Auth\CustomersController;
use App\Http\Controllers\Auth\EmployeesController;
use App\Http\Controllers\Auth\PaymentsController;
use App\Http\Controllers\Auth\RenewsController;
use App\Http\Controllers\Auth\ServicesController;
use App\Models\Renews;
use App\Models\Services;
use Illuminate\Support\Facades\Route;

Route::post('/create_employee',[EmployeesController::class, 'create_employee'])->middleware('auth:sanctum');
Route::post('/create_customer',[CustomersController::class, 'create_customer'])->middleware('auth:sanctum');
Route::post('/create_service',[ServicesController::class, 'create_service'])->middleware('auth:sanctum');
Route::post('/create_renew',[RenewsController::class, 'create_renew'])->middleware('auth:sanctum');
Route::post('/create_payment',[PaymentsController::class, 'create_payment'])->middleware('auth:sanctum');

Route::put('/update_employee/{id}',[EmployeesController::class, 'update_employee'])->middleware('auth:sanctum');
Route::put('/update_customer/{id}',[CustomersController::class, 'update_customer'])->middleware('auth:sanctum');
Route::put('/update_service/{id}',[ServicesController::class, 'update_service'])->middleware('auth:sanctum');
Route::put('/update_renew/{id}',[RenewsController::class, 'update_renew'])->middleware('auth:sanctum');
Route::put('/update_payment/{id}',[PaymentsController::class, 'update_payment'])->middleware('auth:sanctum');
Route::put('/check_renews',[RenewsController::class, 'check_renews'])->middleware('auth:sanctum');

Route::delete('/delete_employee/{id}',[EmployeesController::class, 'delete_employee'])->middleware('auth:sanctum');
Route::delete('/delete_renew/{id}',[RenewsController::class, 'delete_renew'])->middleware('auth:sanctum');
Route::delete('/delete_payment/{id}',[PaymentsController::class, 'delete_payment'])->middleware('auth:sanctum');
Route::delete('/delete_renews_as_checked',[RenewsController::class, 'delete_renews_as_checked'])->middleware('auth:sanctum');

Route::get('/show_all',[EmployeesController::class, 'show_all'])->middleware('auth:sanctum');
Route::get('/show_all_customers',[CustomersController::class, 'show_all_customers'])->middleware('auth:sanctum');
Route::get('/show_all_services',[ServicesController::class, 'show_all_services'])->middleware('auth:sanctum');
Route::get('/search',[CustomersController::class, 'search_customer'])->middleware('auth:sanctum');
Route::get('/get_renews_from_to',[RenewsController::class, 'get_renews_from_to'])->middleware('auth:sanctum');
Route::get('/get_renews_waiting_checked_from_to',[RenewsController::class, 'get_renews_waiting_checked_from_to'])->middleware('auth:sanctum');
Route::get('/get_service/{id}',[ServicesController::class, 'get_service'])->middleware('auth:sanctum');

Route::get('/show/{id}',[EmployeesController::class, 'show'])->middleware('auth:sanctum');
Route::get('/get_customer/{id}',[CustomersController::class, 'get_customer'])->middleware('auth:sanctum');
Route::get('/get_payment/{id}',[PaymentsController::class, 'get_payment'])->middleware('auth:sanctum');
Route::get('/get_payments/{id}',[PaymentsController::class, 'get_payments'])->middleware('auth:sanctum');

Route::get('/get_unpaid_renews',[RenewsController::class, 'get_unpaid_renews'])->middleware('auth:sanctum');
Route::get('/get_customer_renews/{id}',[RenewsController::class, 'get_customer_renews'])->middleware('auth:sanctum');
Route::get('/get_unrenewed_customers',[CustomersController::class, 'get_unrenewed_customers'])->middleware('auth:sanctum');
Route::get('/get_expired_frozen_customers',[CustomersController::class, 'get_expired_frozen_customers'])->middleware('auth:sanctum');


Route::post('/login',[EmployeesController::class,'login']);
