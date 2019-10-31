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

Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
    ],
    function () {
        Route::get('/', 'PagesController@home');

        Route::get('blog/{article_slug}/{translation_slug?}', 'PagesController@article');

        Route::get('categories/{slug}', 'PagesController@category');

        Route::get('tags/{slug}', 'PagesController@tag');
});


Route::get('translations/{translation}/comments', 'CommentsController@index');
Route::post('translations/{translation}/comments', 'CommentsController@store');
Route::post('comments/{comment}/replies', 'RepliesController@store');
Route::post('flagged-comments', 'FlaggedCommentsController@store');
Route::post('flagged-replies', 'FlaggedRepliesController@store');

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

    Route::get('categories', 'CategoriesController@index');
    Route::post('categories', 'CategoriesController@store');
    Route::post('categories/{category}', 'CategoriesController@update');
    Route::delete('categories/{category}', 'CategoriesController@destroy');

    Route::get('articles', 'ArticlesController@index');
    Route::post('articles', 'ArticlesController@store');
    Route::delete('articles/{article}', 'ArticlesController@destroy');
    Route::post('articles/{article}/categories', 'ArticleCategoriesController@update');
    Route::post('articles/{article}/translations', 'TranslationsController@store');
    Route::post('articles/{article}/title-image', 'ArticleTitleImageController@store');

    Route::get('search/articles', 'ArticleSearchController@index');

    Route::get('translations/{translation}', 'TranslationsController@show');
    Route::post('translations/{translation}', 'TranslationsController@update');
    Route::post('translations/{translation}/images', 'TranslationBodyImagesController@store');

    Route::post('published-translations', 'PublishedTranslationsController@store');
    Route::delete('published-translations/{translation}', 'PublishedTranslationsController@destroy');

    Route::get('site-settings/slide-count', 'SlideCountSettingController@show');
    Route::post('site-settings/slide-count', 'SlideCountSettingController@update');

    Route::get('slider/slides', 'SlidesController@index');
    Route::post('slider/slides', 'SlidesController@store');
    Route::delete('slider/{position}', 'SlidesController@destroy');

    Route::get('comments', 'CommentsController@index');
    Route::delete('comments/{comment}', 'CommentsController@destroy');

    Route::get('replies', 'RepliesController@index');
    Route::delete('replies/{reply}', 'RepliesController@destroy');

    Route::get('flagged-comments', 'FlaggedCommentsController@index');
    Route::delete('rejected-flags/{flagged}', 'RejectedFlagsController@destroy');
    Route::delete('enforced-flags/{flagged}', 'EnforcedFlagsController@destroy');

    Route::get('tags', 'TagsController@index');
    Route::delete('tags', 'TagsController@destroy');

    Route::get('tags/{tag}/translations', 'TagTranslationsController@index');
});

Route::group([
    'prefix'     => 'admin/pages',
    'middleware' => ['auth'],
    'namespace'  => 'Admin\Pages'
], function () {
    Route::view("dashboard", "admin.spa-base");

    Route::get('previews/{translation}', 'TranslationPreviewController@show');
});

