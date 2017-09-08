<?php

Route::group(['middleware' => ['web', 'auth:web'], 'prefix' => 'kamehameha'], function ($route) {
    $route->get('/', 'DashboardController@index')->name('back_dashboard');
    
    $route->get('users', 'UserController@index')->name('back_users');
    $route->get('user/{id}/view', 'UserController@view')->where('id', '[0-9]+')->name('back_user_view');
});