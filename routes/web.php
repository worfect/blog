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
    Route::get('gallery', 'Content\GalleryController@index')->name('gallery.index');
    Route::get('gallery/show', 'Content\GalleryController@show')->middleware('only.ajax')->name('gallery.show');
    Route::get('gallery/create', 'Content\GalleryController@create')->middleware('only.ajax');
    Route::get('gallery/edit', 'Content\GalleryController@edit')->middleware('only.ajax');
    Route::get('gallery/delete', 'Content\GalleryController@destroy')->middleware('only.ajax');
    Route::get('gallery/restore', 'Content\GalleryController@restore')->middleware('only.ajax');
    Route::post('gallery/update', 'Content\GalleryController@update')->middleware('only.ajax');
    Route::post('gallery/refresh', 'Content\GalleryController@refresh')->middleware('only.ajax');
    Route::post('gallery', 'Content\GalleryController@store');

    /**
     * Profile.
     */
    Route::get('profile/{id}#user-gallery', 'ProfileController@index')->name('profile.gallery');  #???
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

    Route::get('admin/users', 'Admin\AdminController@showUsers')->name('admin.users');
    Route::get('admin/user/{id}/edit', 'Admin\AdminController@showEditUserForm')->name('admin.user.edit');
    Route::get('admin/user/{id}/delete', 'Admin\AdminController@deleteUser')->name('admin.user.delete');
    Route::get('admin/user/{id}/block', 'Admin\AdminController@blockUser')->name('admin.user.block');
    Route::get('admin/user/{id}/unblock', 'Admin\AdminController@unblockUser')->name('admin.user.unblock');
    Route::get('admin/user/{id}/activate', 'Admin\AdminController@activateUser')->name('admin.user.activate');
    Route::get('admin/user/{id}/deactivate', 'Admin\AdminController@deactivateUser')->name('admin.user.deactivate');

    Route::get('admin/comments', 'Admin\AdminController@showComments')->name('admin.comments');
    Route::get('admin/settings', 'Admin\AdminController@settings')->name('admin.settings');
    Route::get('admin/content', 'Admin\AdminController@content')->name('admin.content');
    Route::get('admin/services', 'Admin\AdminController@services')->name('admin.services');

    /**
     * Comment.
     */
    Route::post('comment', 'Content\CommentController@store')->middleware('only.ajax');
    Route::post('comment/refresh', 'Content\CommentController@refresh')->middleware('only.ajax');

    /**
     * Search.
     */
    Route::get('search', 'Content\SearchController@index')->name('search');
    Route::get('qsearch', 'Content\SearchController@quickSearch')->middleware('only.ajax');

    /**
     * Home.
     */
    Route::get('/', 'Content\HomeController@index')->name('home');
    Route::redirect('/home', '/');

    Route::post('rating', 'RatingController@index')->middleware('only.ajax');


    Route::resources([
        'blog' => 'BlogController',
    ]);

    Route::resource('portfolio', 'Site\PortfolioPage');
    Route::resource('news', 'Site\NewsPage');

    Route::get('comment/show', 'Content\CommentController@show')->name('comment.show');

});


