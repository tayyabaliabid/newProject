<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/welcome', function () {
   return view('welcome');
});

Route::get('/', 'HomeController@index');

Auth::routes();
//Auth::routes(['register' => false]); 
//Route::get('/home', 'HomeController@index')->name('home'); 
//:
Route::middleware('admin')->prefix('admin')->namespace('Admin')->group(function(){
    
    Route::get('dashboard',                 'HomeController@index')->name('admin.home');

    /**
     * user routes
     */
    Route::get('users',                     'UserController@index')->name('admin.users');
    Route::get('user/create',               'UserController@create')->name('admin.user.create');  
    Route::post('user/store',               'UserController@store')->name('admin.user.store');
    Route::get('user/{id}/edit',            'UserController@edit')->name('admin.user.edit'); 
    Route::post('user/{id}/update',         'UserController@update')->name('admin.user.update'); 
    Route::get('user/{id}/destroy',         'UserController@destroy')->name('admin.user.destroy'); 

    /**
     * profile routes
     */
    Route::get('profile',                   'ProfileController@index')->name('admin.profile');
    Route::post('profile/update',           'ProfileController@update')->name('admin.profile.update');
 
    /**
     * numbers controller
     */
    // Route::resource('number',               'NumberController');
    Route::get('numbers',                   'NumberController@index')->name('admin.numbers');
    Route::get('number/create',             'NumberController@create')->name('admin.number.create');  
    Route::post('number/store',             'NumberController@store')->name('admin.number.store');
    Route::get('number/{id}/edit',          'NumberController@edit')->name('admin.number.edit'); 
    Route::post('number/{id}/update',       'NumberController@update')->name('admin.number.update'); 
    Route::get('number/{id}/destroy',       'NumberController@destroy')->name('admin.number.destroy'); 
    Route::post('number/search',            'NumberController@search')->name('admin.number.search');

    /**
     * settings routes
     */
    Route::get('settings',                  'SettingController@index')->name('admin.settings');
    Route::post('settings/update',          'SettingController@update')->name('admin.settings.update');

});   

Route::middleware('user')->prefix('user')->namespace('User')->group(function(){
    
    Route::get('dashboard',                 'HomeController@index')->name('user.home'); 

    /**
     * profile routes
     */
    Route::get('profile',                   'ProfileController@index')->name('user.profile');
    Route::post('profile/update',           'ProfileController@update')->name('user.profile.update');
 

    /**
     * settings routes
     */
    Route::get('settings',                  'SettingController@index')->name('user.settings');
    Route::post('settings/update',          'SettingController@update')->name('user.settings.update');

    
    /**
     * groups routes
     */
    Route::get('groups',                    'GroupController@index')->name('user.groups');
    Route::get('group/create',              'GroupController@create')->name('user.group.create');
    Route::post('group/store',              'GroupController@store')->name('user.group.store'); 
    Route::get('group/{id}/view',           'GroupController@view')->name('user.group.view');
    Route::get('group/{id}/edit',           'GroupController@edit')->name('user.group.edit');
    Route::post('group/{id}/update',        'GroupController@update')->name('user.group.update'); 
    Route::get('group/{id}/destroy',        'GroupController@destroy')->name('user.group.destroy');
    Route::get('group/{id}/destroy_contact','GroupController@destroy_contact')->name('user.contact.destroy');

    
    /**
     * messages routes
     */
    Route::get('messages',                    'MessageController@index')->name('user.messages');
    Route::get('message/create',              'MessageController@create')->name('user.message.create');
    Route::post('message/store',              'MessageController@store')->name('user.message.store'); 
    Route::get('message/{id}/view',           'MessageController@view')->name('user.message.view');
    Route::get('message/{id}/edit',           'MessageController@edit')->name('user.message.edit');
    Route::post('message/{id}/update',        'MessageController@update')->name('user.message.update'); 
    Route::get('message/{id}/destroy',        'MessageController@destroy')->name('user.message.destroy'); 


    /**
     * templates routes
     */
    Route::get('templates',                    'TemplateController@index')->name('user.templates');
    Route::get('template/create',              'TemplateController@create')->name('user.template.create');
    Route::post('template/store',              'TemplateController@store')->name('user.template.store'); 
    Route::get('template/{id}/view',           'TemplateController@view')->name('user.template.view');
    Route::get('template/{id}/edit',           'TemplateController@edit')->name('user.template.edit');
    Route::post('template/{id}/update',        'TemplateController@update')->name('user.template.update'); 
    Route::get('template/{id}/destroy',        'TemplateController@destroy')->name('user.template.destroy'); 

}); 

Route::get('/cmd', function () {
    // Artisan::Call('config:cache');
      Artisan::Call('migrate');
    // Artisan::Call('migrate:rollback');
    // Artisan::Call('migrate:fresh');
    // Artisan::Call('clear-compiled ');
    // Artisan::Call('route:list');
    // Artisan::Call('route:clear');
    // Artisan::Call('make:controller',['name'=>'CallController','-r'=>false]);
    // Artisan::Call('make:model',['name'=>'Number','-m'=>true]);
    // Artisan::Call('make:migration',['name'=>'add_file_path_to_contact_details']); 
    echo "<pre>";
    echo Artisan::Output();
});


