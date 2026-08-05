<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\First;
use App\Http\Controllers\AccountController;

/*
|--------------------------------------------------------------------------
| Basic Pages
|--------------------------------------------------------------------------
*/

Route::get('/', [First::class, 'home']);

Route::get('/home',
[First::class, 'home']);

Route::get('/about',
[First::class, 'about']);

Route::get('/contact',
[First::class, 'contact']);

/*
|--------------------------------------------------------------------------
| Banking Pages
|--------------------------------------------------------------------------
*/

Route::get('/createac',
[First::class, 'createac']);

Route::get('/deposite',
[First::class, 'deposit']);

Route::get('/withdraw',
[First::class, 'withdraw']);

Route::get('/balanceinq',
[First::class, 'balanceinq']);

Route::get('/fundtransfer',
[First::class, 'fundtransfer']);

Route::get('/pinchange',
[First::class, 'pinchange']);

Route::get('/acsummury',
[First::class, 'acsummury']);

/*
|--------------------------------------------------------------------------
| Account Operations
|--------------------------------------------------------------------------
*/

/* Create Account */

Route::post('/account/create',
[AccountController::class,
'createAccount']);

/* Deposit */

Route::post('/account/deposit',
[AccountController::class,
'deposit']);

/* Withdraw */

Route::post('/account/withdraw',
[AccountController::class,
'withdraw']);

/* Fund Transfer */

Route::post('/account/transfer',
[AccountController::class,
'transfer']);

/* Change PIN */

Route::post('/account/change-pin',
[AccountController::class,
'changePin']);

/* Account Summary */

Route::get('/account/summary/{accountId}',
[AccountController::class,
'getAccountSummary']);

/* Balance Inquiry */

Route::get('/account/balance/{accountId}',
[AccountController::class,
'getBalance']);

/* Transaction History */

Route::get('/account/history/{accountId}',
[AccountController::class,
'transactionHistory']);