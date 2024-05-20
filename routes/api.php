<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['middleware' => ['cors', 'localization']], function () {
    Route::get('/getApiToken' , function (){
        return redirect()->to(payLinkAddInvoice(9 , 'test@email.com' , '050000000' , 'nour' , 105));
    });
});
