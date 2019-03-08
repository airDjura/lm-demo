<?php

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
    Auth::routes();
    // Example Routes
    Route::view('/', 'landing');

    Route::name('admin.')
         ->prefix('admin')
         ->namespace('Admin')
         ->middleware('auth')
         ->group(function() {
             Route::get('/dashboard', 'DashboardController@index')
                  ->name('dashboard');
             Route::get('/examples/blank', function() {
                 return view('admin.examples.blank');
             })
                  ->name('examples.blank');
         });

    Route::get('/home', 'HomeController@index')
         ->name('home');
