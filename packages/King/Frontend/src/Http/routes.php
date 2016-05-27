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
    Route::get('/strong_password', ['as' => 'front_strong_pass', 'uses' => 'SettingsController@strongPassword']);
});

Route::group(['middleware' => ['web', 'auth:web']], function () {
    Route::get('settings', ['as' => 'front_setting', 'uses' => 'SettingsController@index']);
    Route::post('settings/publish_profile', ['as' => 'front_setting_publish_profile', 'uses' => 'SettingsController@publishProfile']);
    Route::post('settings/upload_avatar', ['as' => 'front_settings_upload_avatar', 'uses' => 'SettingsController@uploadAvatar']);
    Route::post('settings/upload_cover', ['as' => 'front_settings_upload_cover', 'uses' => 'SettingsController@uploadCover']);
});