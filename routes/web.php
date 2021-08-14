<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>'generate.menus'], function(){
    /**
     * Register the typical authentication routes for an application.
     */
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login')->name('login');

    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    Route::get('auth/{provider}', 'Auth\AuthSocialController@redirectToProvider')->name('auth.social');
    Route::get('auth/{provider}/callback', 'Auth\AuthSocialController@handleProviderCallback')->name('auth.social.callback');

    Route::post('verify', 'Auth\VerificationController@verification')->name('verification.verify');
    Route::get('verify', 'Auth\VerificationController@show')->name('verification.notice');
    Route::post('resend', 'Auth\VerificationController@resend')->name('verification.resend');

    Route::get('password/forgot', 'Auth\ForgotPasswordController@showPasswordForgotForm')->name('password.forgot.form');
    Route::post('password/forgot', 'Auth\ForgotPasswordController@sendRequestAvailableWay')->name('password.forgot');

    Route::get('password/reset', 'Auth\ResetPasswordController@showPasswordResetForm')->name('password.reset.form');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset')->middleware('throttle:10,1');

    Route::get('password/change', 'Auth\ChangePasswordController@showPasswordChangeForm')->name('password.change.form');
    Route::post('password/change', 'Auth\ChangePasswordController@change')->name('password.change')->middleware('throttle:10,1');

    Route::get('password/conform', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm.form');
    Route::post('password/conform', 'Auth\ConfirmPasswordController@confirm')->name('password.confirm');

    /**
     * Gallery.
     */
    Route::get('gallery', 'GalleryController@index')->name('gallery.index');
    Route::get('gallery/show', 'GalleryController@show')->middleware('only.ajax')->name('gallery.show');
    Route::get('gallery/create', 'GalleryController@create')->middleware('only.ajax');
    Route::get('gallery/edit', 'GalleryController@edit')->middleware('only.ajax');
    Route::get('gallery/delete', 'GalleryController@destroy')->middleware('only.ajax');
    Route::get('gallery/restore', 'GalleryController@restore')->middleware('only.ajax');
    Route::post('gallery/update', 'GalleryController@update')->middleware('only.ajax');
    Route::get('gallery/refresh', 'GalleryController@refresh')->middleware('only.ajax');
    Route::post('gallery', 'GalleryController@store');

    /**
     * Profile.
     */
    Route::get('profile/gallery', 'ProfileController@index')->name('profile.gallery');
    Route::get('profile/{id}/multi-factor/{action}', 'ProfileController@multiFactorRequest')->name('profile.multi-factor')->middleware('password.confirm');
    Route::get('profile/{id}/verify/{source}', 'ProfileController@verifyRequest')->name('profile.verify');
    Route::get('profile/{id}/edit', 'ProfileController@edit')->name('profile.edit');
    Route::get('profile/{id}/update/refresh', 'ProfileController@refresh')->middleware('only.ajax');
    Route::post('profile/{id}/update', 'ProfileController@update')->name('profile.update')->middleware('password.confirm');
    Route::get('profile/{id}', 'ProfileController@index')->name('profile');
    Route::get('profile', function (){
        if($id = Auth::id()){
            return redirect("profile/$id");
        }
        return redirect(\route('home'));
    })->name('profile.default');



    /**
     * Comment.
     */
    Route::post('comment', 'CommentController@store')->middleware('only.ajax');
    Route::post('comment/refresh', 'CommentController@refresh')->middleware('only.ajax');

    /**
     * Search.
     */
    Route::get('search', 'SearchController@index')->name('search');
    Route::get('qsearch', 'SearchController@quickSearch')->middleware('only.ajax');

    /**
     * Home.
     */
    Route::get('/', 'HomeController@index')->name('home');
    Route::redirect('/home', '/');

    Route::post('rating', 'RatingController@index')->middleware('only.ajax');


    Route::resources([
        'blog' => 'BlogController',
    ]);

    Route::resource('portfolio', 'Site\PortfolioPage');
    Route::resource('news', 'Site\NewsPage');
});


