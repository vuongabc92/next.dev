<?php
/**
 * List routes of frontend
 */

Route::group(['middleware' => 'web'], function () {

    // Authentication Routes.
    Route::get('login', ['as' => 'front_login', 'uses' => 'Auth\AuthController@showLoginForm']);
    Route::post('login', ['as' => 'front_login_post', 'uses' => 'Auth\AuthController@postLogin']);

    // Registration Routes.
    Route::get('register', ['as' => 'front_register', 'uses' => 'Auth\AuthController@showRegistrationForm']);
    Route::post('register', ['as' => 'front_register_post', 'uses' => 'Auth\AuthController@register']);

    // Password Reset Routes.
    Route::get('password/reset/{token?}', ['as' => 'front_password_reset_token', 'uses' => 'Auth\PasswordController@showResetForm']);
    Route::post('password/email', ['as' => 'front_password_email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
    Route::post('password/reset', ['as' => 'front_password_reset', 'uses' => 'Auth\PasswordController@reset']);

    Route::get('/', ['as' => 'front_home', 'uses' => 'HomeController@index']);
});

