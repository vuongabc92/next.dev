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
    $route->get('settings/theme', 'SettingsController@theme')->name('front_settings_theme');
    $route->post('theme/install', 'SettingsController@install')->name('front_theme_install');
    $route->post('theme/add_new', 'SettingsController@addNewTheme')->name('front_theme_add_new')->middleware('master');
    $route->get('theme/{slug}/preview', 'ResumeController@preview')->name('front_theme_preview');
    $route->get('theme/{slug}/download', 'ResumeController@download')->name('front_theme_download');
});

Route::group(['middleware' => 'web'], function ($route) {
    
    // Authentication Routes.
    $route->get('login', 'Auth\LoginController@showLoginForm')->name('front_login');
    $route->post('login', 'Auth\LoginController@login')->name('front_login_post');
    $route->get('logout', 'Auth\LoginController@logout')->name('front_logout');
    $route->get('facebook-authenticate', 'Auth\LoginController@loginWithFBCallback')->name('front_login_with_fbcallback');
    $route->get('google-authenticate', 'Auth\LoginController@loginWithGoogle')->name('front_login_with_gcallback');

    // Registration Routes.
    $route->get('register', 'Auth\RegisterController@showRegistrationForm')->name('front_register');
    $route->post('register', 'Auth\RegisterController@register')->name('front_register_post');

    // Password Reset Routes.
    $route->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('front_forgotpass');
    $route->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('front_forgotpass_post');
    $route->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('front_resetpass');
    $route->post('password/reset', 'Auth\ResetPasswordController@reset')->name('front_resetpass_post');
    
    $route->get('/', 'IndexController@index')->name('front_index');
    $route->get('/contact', 'IndexController@contact')->name('front_contact');
    $route->get('/developer', 'IndexController@developer')->name('front_developer');
    $route->get('/privacy-policy', 'IndexController@privacyPolicy')->name('front_privacy_policy');
    $route->get('/terms-and-conditions', 'IndexController@termsAndConditions')->name('front_terms_conditions');
    
    $route->get('themes', 'SettingsController@lazyLoadTheme')->name('front_themes_lazy');
    $route->get('theme/{slug}/details', 'SettingsController@themeDetails')->name('front_theme_details');
    
    $route->get('i/{slug?}', 'ResumeController@index')->name('front_cv');
});