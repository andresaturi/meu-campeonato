<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

use App\Repositories\Championships\ChampionshipsRepository;

class ChampionshipsController extends Controller
{
    protected ChampionshipsRepository $championshipsRepository;

    public function __construct(championshipsRepository $championshipsRepository)
    {
        $this->championshipsRepository = $championshipsRepository;
    }

    /**
     * Get Championship
     */
    public function getChampionships($id = null){

        try {
            if($id){
                $championships = $this->championshipsRepository->getChampionshipById($id);
            }else{
                $championships = $this->championshipsRepository->getAllChampionships();
            }
            return $championships
            ? response()->json(['championships' => $championships], Response::HTTP_OK)
            : response()->json(['error' => 'Nenhum campeonato encontrado'], Response::HTTP_NOT_FOUND);
        
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Store Championship
     */
    public function storeChampionship(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $success = $this->championshipsRepository->storeChampionship($request);
            return $success
            ? response()->json(['success' => 'Campeonato criado com sucesso!'], Response::HTTP_CREATED)
            : response()->json(['failure' => 'Erro ao salvar campeonato'], Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
