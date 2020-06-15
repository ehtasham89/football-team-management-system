<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        // Below mention routes are public, user can access those without any restriction.
        // Create New User
        Route::post('register', 'AuthController@register');
        // Login User
        Route::post('login', 'AuthController@login');
        
        // Refresh the JWT Token
        Route::get('refresh', 'AuthController@refresh');
    });

    // Below mention routes are available only for the authenticated users.
    Route::middleware('auth:api')->group(function () {
        Route::prefix('auth')->group(function () {
            // Get user info
            Route::get('user/{id?}', 'AuthController@user');
            // Logout user from application
            Route::post('logout', 'AuthController@logout');
        });

        // teams rest api routes
        Route::prefix('teams')->group(function () {
            Route::get('/', 'TeamsController@getList');
            Route::get('{id}', 'TeamsController@getTeamPlayer');
            Route::post('new', 'TeamsController@create');
            Route::put('{id}/status/{status}', 'TeamsController@updateStatus');
        });

        // players rest api routes
        Route::prefix('players')->group(function () {
            Route::get('/', 'PlayersController@getList'); //unassinged list
            Route::post('new', 'PlayersController@create');
            Route::put('{id}/status/{status}', 'PlayersController@updateStatus');
            Route::put('{id}/with/{p_id}/type/{type}', 'PlayersController@assignPlayer');
        });

        // csv import api routes
        Route::get('csv/import', 'PlayersController@teamPlayerImport'); 
    });
});