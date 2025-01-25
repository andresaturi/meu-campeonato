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