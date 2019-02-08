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

Route::get('/', 'DashboardController@index');

Route::prefix('/login')->namespace('Auth')->group(function () {
    Route::get('discord', 'DiscordLoginController@redirectToProvider');
    Route::get('discord/callback', 'DiscordLoginController@handleProviderCallback');
});

Route::get('/logout', 'Auth\\LogoutController');

Route::resource('media', 'MediaController')->except(['create', 'edit']);
Route::get('/imdb', 'ImdbSearchController')->name('imdb-search');
