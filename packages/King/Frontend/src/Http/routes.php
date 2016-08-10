<?php
/**
 * List routes of frontend
 */

Route::group(['middleware' => 'web'], function () {

    // Authentication Routes.
    Route::get('login', ['as' => 'front_login', 'uses' => 'Auth\AuthController@showLoginForm']);
    Route::post('login', ['as' => 'front_login_post', 'uses' => 'Auth\AuthController@postLogin']);
    Route::get('logout', ['as' => 'front_login', 'uses' => 'Auth\AuthController@logout']);

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
    Route::post('settings/save_info', ['as' => 'front_settings_save_info', 'uses' => 'SettingsController@saveInfo']);
    Route::post('settings/select_place', ['as' => 'front_settings_select_place', 'uses' => 'SettingsController@createAddressSelectData']);
    Route::get('settings/employment_history/{id?}', ['as' => 'front_settings_employmentbyid', 'uses' => 'SettingsController@getEmploymentHistoryById'])->where('id', '[0-9]+');
    Route::delete('settings/employment_history_remove', ['as' => 'front_settings_employmentremovebyid', 'uses' => 'SettingsController@removeEmploymentHistoryById']);
    Route::delete('settings/education_history_remove', ['as' => 'front_settings_educationremovebyid', 'uses' => 'SettingsController@removeEducationHistoryById']);
    Route::get('settings/education_history/{id?}', ['as' => 'front_settings_educationbyid', 'uses' => 'SettingsController@getEducationHistoryById'])->where('id', '[0-9]+');
});