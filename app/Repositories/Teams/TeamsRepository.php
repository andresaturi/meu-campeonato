<?php

namespace App\Repositories\Teams;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

use App\Models\Teams;


class TeamsRepository{

    public function getTeamById($id){
        return Teams::find($id);
    }

    public function getAllTeams(){
        return Teams::all();
    }

    public function getTeamsActive(){
        return Teams::where('eliminated', 0)->get();
    }    

    public function resetScore(){
        Teams::query()->update([
            'score' => 0,
            'eliminated' => 0,
        ]);
    }

    public function updateScore($teams){
        foreach($teams as $team){
            $teamUpdate = Teams::find($team['id']);
            $teamUpdate->score += $team['balance'];
            $teamUpdate->eliminated = $team['eliminated'];
            $teamUpdate->save();  
        }
    }

    public function storeTeam($data){

        DB::beginTransaction();

        try {
            if(isset($data->id)){
                $team = Teams::find($data->id);
            }else{
                $team = new Teams();
            }

            $team->name = $data->name; 

            if($team->save()){
                DB::commit(); 
                return true;
            }else{
                DB::rollBack(); 
                return false;
            }

        } catch (\Exception $e) {
            DB::rollBack(); 
            return $e;
        }
    }
   
}