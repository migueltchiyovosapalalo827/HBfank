<?php

use App\Http\Controllers\Api\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/admin/{any}', function () {
    return   view('app');
})->where('any','.*');

Route::get('/admin', function () {
    return   view('app');
});

Route::get('/{any}', function () {
           if (auth()->user()) {
               # code...
               if (auth()->user()->hasRole(['admin','gerente'])) {
                   # code...
               return view('app');
               } else {
                   # code...

               return view('home');
               }
               return view('home');
           }
           return view('home');
})->where('any','.*');

Route::get('/{detalhe?}', function () {
    return   view('home');
})->where('detalhe','detalhe');

Route::get('/', function () {
    return   view('home');
});



require __DIR__.'/auth.php';
