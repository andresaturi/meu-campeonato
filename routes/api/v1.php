<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamsController;

Route::get('/team/{id}', [TeamsController::class, 'getTeamById']);
Route::get('/teams', [TeamsController::class, 'getTeams']);
Route::post('/store-team', [TeamsController::class, 'storeTeam']);
Route::put('/update-team', [TeamsController::class, 'storeTeam']);