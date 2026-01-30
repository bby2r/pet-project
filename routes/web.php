<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', MainController::class)->name('home');
Route::post('upload-file', [MainController::class, 'uploadFile'])->name('upload-file');


Route::get('/files/{base64}', [MainController::class, 'showFile'])->name('show-file');
