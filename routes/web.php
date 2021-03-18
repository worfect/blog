<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>'generate.menus'], function(){
    /**
     * Search.
     */
    Route::get('search', 'Site\SearchPage@index')->name('search');
    Route::get('qsearch', 'QuickSearchController@search');


    /**
     * Register the typical authentication routes for an application.
     */
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@authenticate')->name('login');

    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    Route::get('auth/{provider}', 'Auth\AuthSocialController@redirectToProvider')->name('auth.social');
    Route::get('auth/{provider}/callback', 'Auth\AuthSocialController@handleProviderCallback')->name('auth.social.callback');

    Route::get('email/verify/{token}', 'Auth\VerificationController@myVerify')->name('verification.verify');
    Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/message', 'Auth\ForgotPasswordController@initializationSendMethod')->name('password.message');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    /**
     * Gallery.
     */
    Route::get('gallery', 'Site\GalleryPage@index')->name('gallery.index');
    Route::get('gallery/show', 'Site\GalleryPage@show')->middleware('only.ajax');
    Route::get('gallery/create', 'Site\GalleryPage@create')->middleware('only.ajax');
    Route::get('gallery/edit', 'Site\GalleryPage@edit')->middleware('only.ajax');
    Route::get('gallery/delete', 'Site\GalleryPage@destroy')->middleware('only.ajax');
    Route::get('gallery/restore', 'Site\GalleryPage@restore')->middleware('only.ajax');
    Route::post('gallery/update', 'Site\GalleryPage@update')->middleware('only.ajax');
    Route::post('gallery', 'Site\GalleryPage@store');

    /**
     * Profile.
     */
    Route::get('/profile/{id}/gallery', 'Site\ProfilePage@gallery')->name('profile.gallery');

    /**
     * Comment.
     */
    Route::post('comment/store', 'CommentController@store')->middleware('only.ajax');


    /**
     * Other.
     */
    Route::post('refresh', 'CommentController@store')->middleware('only.ajax');


    Route::resources([
        'blog' => 'Site\BlogPage',
    ]);

    Route::resource('portfolio', 'Site\PortfolioPage');
    Route::resource('news', 'Site\NewsPage');


    Route::get('profile/{id}', 'Site\ProfilePage@index')->name('profile');


    Route::get('/', 'Site\HomePage@index')->name('home');
});


