<?php

use Illuminate\Http\Request;

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

Route::namespace('Api\Admin')->middleware('auth:api')->group(function () {
    Route::get('/user', 'UserController@getAuthUser');
    Route::post('/user/editSeason', 'UserController@editSeason');

    Route::prefix('search')->group(function() {
        Route::get('clubs', 'SearchController@club');
        Route::get('seasons', 'SearchController@season');
        Route::get('leagues', 'SearchController@league');
    });

    Route::name('club.')->prefix('clubs')->group(function () {
        Route::resource('', 'ClubController')->parameters(['' => 'club']);
        Route::get('{club}/players', 'ClubController@getPlayers');
    });
    Route::resource('leagues', 'LeagueController');
    Route::resource('players', 'PlayerController');
    Route::resource('seasons', 'SeasonController');
    Route::resource('venues', 'VenueController');
    Route::name('schedule.')->prefix('schedules')->group(function () {
        Route::resource('', 'ScheduleController')->parameters(['' => 'schedule']);
        Route::resource('{schedule}/teams', 'TeamController');
        Route::resource('{schedule}/games', 'GameController');
        Route::post('{schedule}/addGroup', 'ScheduleController@addGroup');
        Route::post('{schedule}/generate', 'ScheduleController@generate');
        Route::delete('{schedule}/deleteAllGames', 'ScheduleController@deleteAllGames');
        Route::delete('{schedule}/deleteGroup/{group}', 'ScheduleController@deleteGroup');
        Route::get('{schedule}/getGroups', 'ScheduleController@getGroups');
        Route::get('{schedule}/clubs/{club}/getPlayers', 'TeamController@getPlayers');
        Route::get('{schedule}/teams/{team}/getPlayers', 'TeamController@getEditPlayers');
        Route::post('{schedule}/teams/{team}/changeGroup', 'TeamController@changeGroup');
    });

    Route::post('players/{player}/upload', 'PlayerController@setProfileImage');
    Route::name('media.')->prefix('media')->group(function () {
        Route::post('/{uuid}/images/{type}', 'MediaController@uploadImages')->name('upload');
        Route::get('{assetType}/{uuid}/images/{type}', 'MediaController@getImagesByType')->name('getByType');
        Route::get('/{uuid}', 'MediaController@getByUuid')->name('show');
        Route::delete('/{uuid}', 'MediaController@delete')->name('delete');
    });
});
