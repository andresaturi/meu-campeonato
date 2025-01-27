<?php

namespace App\Repositories\Matches;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Carbon\Carbon;

use App\Models\Matches;


class MatchesRepository{

    public function getMatcheById($id){
        return Matches::find($id);
    }

    public function getMatcheByChampionship($championship_id){
        if($championship_id){
            return Matches::where('championship_id', $championship_id)->get;
        }
        return Matches::all();  
    }

    public function getAllMatches(){
        return Matches::all();
    }  

    public function getTeamsthird(){
        return Matches::where('stage_id', 2)->get();
    }

    public function resetMatches($championship_id){
        $matches = Matches::where('championship_id', $championship_id)->get();
        foreach ($matches as $match) {
            $match->delete(); 
        }
    }

    public function storeMatche($teams, $championship){

        return DB::transaction(function () use ($teams, $championship) {
            $winnerId = $teams[1]['eliminated'] ? $teams[0]['id'] : $teams[1]['id'];

            $attributes = [
                'championship_id' => $championship->id,
                'stage_id' => $championship->stage,
                'home_team_id' => $teams[0]['id'],
                'away_team_id' => $teams[1]['id'],
                'home_team_goals' => $teams[0]['goals'] ?? null,
                'away_team_goals' => $teams[1]['goals'] ?? null,
                'home_team_extra_time' => $teams[0]['extra_time'] ?? null,
                'away_team_extra_time' => $teams[1]['extra_time'] ?? null,
                'home_team_penalties' => $teams[0]['penalties'] ?? null,
                'away_team_penalties' => $teams[1]['penalties'] ?? null,
                'winner_id' => $winnerId,
                'match_date' => Carbon::now(),
            ];

            $matche = new Matches();
            $matche->fill($attributes);

            if (!$matche->save()) {
                throw new \RuntimeException('Failed to save match.');
            }

            return true;
        });
    }

   
}