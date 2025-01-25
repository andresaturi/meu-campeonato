<?php

namespace App\Repositories\Championships;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

use App\Models\Championships;


class ChampionshipsRepository{

    public function getChampionshipById($id){
        return Championships::find($id);
    }

    public function getAllChampionships(){
        return Championships::all();
    }

    public function storeChampionship($data){

        DB::beginTransaction();

        try {
            if(isset($data->id)){
                $championship = Championships::find($data->id);
            }else{
                $championship = new Championships();
            }

            $championship->name = $data->name; 

            if($championship->save()){
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