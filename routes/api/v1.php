<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\ChampionshipsController;

Route::get('/team/{id}', [TeamsController::class, 'getTeamById']);
Route::get('/teams', [TeamsController::class, 'getTeams']);
Route::post('/store-team', [TeamsController::class, 'storeTeam']);
Route::put('/update-team', [TeamsController::class, 'storeTeam']);

Route::get('/championship/{id}', [ChampionshipsController::class, 'getChampionshipById']);
Route::get('/championships', [ChampionshipsController::class, 'getChampionships']);
Route::post('/store-championship', [ChampionshipsController::class, 'storeChampionship']);
Route::put('/update-championship', [ChampionshipsController::class, 'storeChampionship']);