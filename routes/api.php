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
        
        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('user/{id?}', 'AuthController@user');
            // Logout user from application
            Route::post('logout', 'AuthController@logout');
        });
    });

    Route::prefix('teams')->group(function () {
        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:api')->group(function () {
            Route::get('/', 'TeamsController@getList');
            Route::get('/{team_id}', 'TeamsController@getTeamPlayer');
            Route::post('/new', 'TeamsController@create');
            Route::put('/status/{team_id}/{status}', 'TeamsController@updateStatus');
        });
    });

    Route::prefix('players')->group(function () {
        Route::middleware('auth:api')->group(function () {
            Route::get('/', 'PlayersController@getList'); //unassinged list
            Route::get('/{player_id}', 'PlayersController@getPlayer');
            Route::post('/new', 'PlayersController@create');
            Route::put('/status/{player_id}/{status}', 'PlayersController@updateStatus');
            Route::put('/type/{player_id}/{type}', 'PlayersController@changeType');
            Route::post('/replace-player/{team_id}', 'PlayersController@replacePlayer');
        });
    });
});