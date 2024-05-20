<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', 'UserController@index')->name('login');

Route::post('/login123', 'LoanDetailController@login')->name('login.submit');
Route::get('/loan-details', 'LoanDetailController@loan')->name('loan-details');
Route::get('/process-page', 'emiDetailController@index')->name('process-page');
Route::post('/process-page', 'emiDetailController@EmiDetail')->name('process-data');






