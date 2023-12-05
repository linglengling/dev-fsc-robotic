<?php
//Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => []], function () {
    // Season
    Route::apiResource('seasons', 'SeasonApiController');
    Route::get('seasons/index-teams/{season}', 'SeasonApiController@indexteams')->name('seasons.indexteams');

    // Match
    Route::apiResource('matches', 'MatchApiController');

    // Score Detail
    Route::apiResource('score-details', 'ScoreDetailApiController');

    // Team
    Route::apiResource('teams', 'TeamApiController');

    // Match Team
    Route::apiResource('match-teams', 'MatchTeamApiController');
});
