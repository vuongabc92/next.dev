<?php
/**
 * List routes of frontend
 */

Route::group(['middleware' => ['web', 'auth:web']], function ($route) {
    $route->get('settings', 'SettingsController@index')->name('front_settings');
    $route->post('settings/publish_profile', 'SettingsController@publishProfile')->name('front_setting_publish_profile');
    $route->post('settings/upload_avatar', 'SettingsController@uploadAvatar')->name('front_settings_upload_avatar');
    $route->post('settings/upload_cover', 'SettingsController@uploadCover')->name('front_settings_upload_cover');
    $route->post('settings/save_info', 'SettingsController@saveInfo')->name('front_settings_save_info');
    $route->post('settings/select_place', 'SettingsController@createAddressSelectData')->name('front_settings_select_place');
    $route->get('settings/employment_history/{id?}', 'SettingsController@getEmploymentHistoryById')->where('id', '[0-9]+')->name('front_settings_employmentbyid');
    $route->delete('settings/employment_history_remove', 'SettingsController@removeEmploymentHistoryById')->name('front_settings_employmentremovebyid');
    $route->delete('settings/education_history_remove', 'SettingsController@removeEducationHistoryById')->name('front_settings_educationremovebyid');
    $route->get('settings/education_history/{id?}', 'SettingsController@getEducationHistoryById')->where('id', '[0-9]+')->name('front_settings_educationbyid');
    $route->delete('settings/kill_tag', 'SettingsController@killTag')->name('front_settings_killtag');
    $route->delete('settings/kill_social', 'SettingsController@killSocial')->name('front_settings_killsocial');
    $route->get('settings/search_skill/{keyword?}', 'SettingsController@searchSkill')->name('front_settings_searchskill');
    $route->post('theme/install', 'ThemeController@install')->name('front_theme_install');
});

Route::group(['middleware' => 'web'], function ($route) {

    $route->get('developer', 'Auth\LoginController@showLoginForm')->name('front_developer');
    
    // Authentication Routes.
    $route->get('login', 'Auth\LoginController@showLoginForm')->name('front_login');
    $route->post('login', 'Auth\LoginController@login')->name('front_login_post');
    $route->get('logout', 'Auth\LoginController@logout')->name('front_logout');

    // Registration Routes.
    $route->get('register', 'Auth\RegisterController@showRegistrationForm')->name('front_register');
    $route->post('register', 'Auth\RegisterController@register')->name('front_register_post');

    // Password Reset Routes.
    $route->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('front_forgotpass');
    $route->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('front_forgotpass_post');
    $route->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('front_resetpass');
    $route->post('password/reset', 'Auth\ResetPasswordController@reset')->name('front_resetpass_post');
    
    Route::get('/', ['as' => 'front_home', 'uses' => 'HomeController@index']);
    
    Route::get('themes', 'ThemeController@index')->name('front_themes');
    Route::get('theme/popup_details', 'ThemeController@themeDetails')->name('front_theme_details');
    
    Route::get('{slug?}', 'ResumeController@index')->name('front_cv');
});