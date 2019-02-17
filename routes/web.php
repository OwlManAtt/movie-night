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
    Route::get('/', 'LandingController')->name('login');
    Route::get('discord', 'DiscordLoginController@redirectToProvider')->name('oauth-start');
    Route::get('discord/callback', 'DiscordLoginController@handleProviderCallback');
});

Route::get('/logout', 'Auth\\LogoutController')->name('logout');

Route::resource('media', 'MediaController')->except(['create', 'edit']);
Route::resource('media.episode', 'EpisodeController')->only(['index']);

Route::get('/imdb', 'ImdbSearchController')->name('imdb-search');
