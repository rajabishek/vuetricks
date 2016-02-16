<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::group(['namespace' => 'Admin','prefix' => 'admin'], function () {
    
        Route::get('users', 'UsersController@index');
        
        Route::resource('tags', 'TagsController');
        
        Route::resource('categories', 'CategoriesController');
    });

	Route::get('/', ['as' => 'pages.home', 'uses' => 'PagesController@getHome']);
   
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function() {
    	
    	Route::get('register', ['as' => 'auth.getRegister', 'uses' => 'AuthController@getRegister']);
   		Route::post('register', ['as' => 'auth.postRegister', 'uses' => 'AuthController@postRegister']);

   		Route::get('login', ['as' => 'auth.getLogin', 'uses' => 'AuthController@getLogin']);
   		Route::post('login', ['as' => 'auth.postlogin', 'uses' => 'AuthController@postLogin']);

        Route::get('github', ['as' => 'auth.github', 'uses' => 'AuthController@redirectToProvider']);
        Route::get('github/callback', 'AuthController@handleProviderCallback');
    
    	Route::get('logout', [ 'as' => 'auth.logout', 'uses' => 'AuthController@getLogout']);
    });

    Route::get('tricks/{trick_slug?}', [ 'as' => 'tricks.show', 'uses' => 'TricksController@getShow' ]);
    Route::post('tricks/{trick_slug}/like', [ 'as' => 'tricks.like', 'uses' => 'TricksController@postLike']);
    Route::resource('user/tricks','UserTricksController', ['except' => 'show']);
});
