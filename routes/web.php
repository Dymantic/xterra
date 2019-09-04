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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Auth'], function () {
    Route::view('login', 'auth.login')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');

    Route::view('password/request', 'auth.password-request')->name('password.request');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'ResetPasswordController@reset')
         ->name('password.update');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'namespace' => 'Admin'], function () {
    Route::get('me', 'ProfileController@show');
    Route::post('me', 'ProfileController@update');
    Route::post('me/password', 'UserPasswordController@update');

    Route::get('users', 'UsersController@index');
    Route::post('users', 'UsersController@store');
    Route::delete('users/{user}', 'UsersController@destroy');

    Route::post('categories', 'CategoriesController@store');
    Route::post('categories/{category}', 'CategoriesController@update');
    Route::delete('categories/{category}', 'CategoriesController@destroy');

    Route::post('articles', 'ArticlesController@store');
    Route::post('articles/{article}/categories', 'ArticleCategoriesController@update');
    Route::post('articles/{article}/translations', 'TranslationsController@store');

    Route::post('translations/{translation}', 'TranslationsController@update');

    Route::post('published-translations', 'PublishedTranslationsController@store');
    Route::delete('published-translations/{translation}', 'PublishedTranslationsController@destroy');
});

Route::group([
    'prefix'     => 'admin/pages',
    'middleware' => ['auth'],
    'namespace'  => 'Admin\Pages'
], function () {
    Route::view("dashboard", "admin.spa-base");
});

