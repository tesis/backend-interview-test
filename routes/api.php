<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Invoices\Presentation\Http\Controllers\InvoicesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(InvoicesController::class)->group(function () {
    Route::get('/invoices', 'index');
    Route::get('/invoice/{invoice}', 'show');
    Route::put('/invoice/{invoice}/approve', 'approve');
    Route::put('/invoice/{invoice}/reject', 'reject');
    Route::put('/invoice/{invoice}/restoreApproval', 'restoreApproval');
});
