<?php

Route::group(['middleware' => ['web', 'auth:web'], 'prefix' => 'kamehameha'], function ($route) {
    $route->get('/', 'DashboardController@index')->name('back_dashboard');
    
    $route->get('users', 'UserController@index')->name('back_users');
    $route->get('user/{id}/view', 'UserController@view')->where('id', '[0-9]+')->name('back_user_view');
    $route->post('user/update_status', 'UserController@updateStatus')->name('back_user_status');
    $route->post('user/remove', 'UserController@remove')->name('back_user_remove');
    
    $route->get('themes', 'ThemeController@index')->name('back_themes');
    $route->get('theme/{id}/view', 'ThemeController@view')->name('back_theme_view');
    $route->get('theme/{id}/edit', 'ThemeController@edit')->name('back_theme_edit');
    $route->post('theme/save', 'ThemeController@save')->name('back_theme_save');
    $route->post('theme/update_status', 'ThemeController@updateStatus')->name('back_theme_status');
    $route->post('theme/remove', 'ThemeController@remove')->name('back_theme_remove');
    
    $route->get('page/about-us', 'PageController@aboutus')->name('back_page_aboutus');
    $route->post('page/about-us/save', 'PageController@saveAboutus')->name('back_page_saveaboutus');
    $route->get('page/contact', 'PageController@contact')->name('back_page_contact');
    $route->post('page/contact/save', 'PageController@saveContact')->name('back_page_savecontact');
    $route->get('page/developer', 'PageController@developer')->name('back_page_developer');
    $route->post('page/developer/save', 'PageController@saveDeveloper')->name('back_page_savedeveloper');
    $route->get('page/privacy', 'PageController@privacy')->name('back_page_privacy');
    $route->post('page/privacy/save', 'PageController@savePrivacy')->name('back_page_saveprivacy');
    $route->get('page/terms', 'PageController@terms')->name('back_page_terms');
    $route->post('page/terms/save', 'PageController@saveTerms')->name('back_page_saveterms');
});