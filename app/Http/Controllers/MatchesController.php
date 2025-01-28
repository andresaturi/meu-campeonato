<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Services\MatcheService;
use App\Repositories\Matches\MatchesRepository;

class MatchesController extends Controller
{
    public function __construct(MatcheService $matchesService, MatchesRepository $matchesRepository){
       
        $this->matchesService = $matchesService;
        $this->matchesRepository = $matchesRepository;
    }

    /**
     * Play Matches
     */
    public function playMatches(Request $request){
       
        $validated = $request->validate([
            'championship_id' => 'required|integer',
        ]);
   
        try {              
            
            $result = $this->matchesService->playMatches($validated['championship_id']);    
           
            if($result){
                return response()->json([
                    'success' => true,
                    'message' => 'Partidas processadas com sucesso.',              
                    'result' => $result,
                ], Response::HTTP_OK);
            }
        } catch (\Exception $e) {           
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao processar as partidas.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Get Matches
     */
     
    public function getMatches($championship_id = null){

        try{
            $matches = $this->matchesRepository->getMatcheByChampionship($championship_id);
            return response()->json($matches,  Response::HTTP_OK);

        }catch (\Exception $e) {           
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao resgatar as partidas.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get Results
     */
    public function getResults($championship_id){

        try{
            $results = $this->matchesService->ranking($championship_id);
            return response()->json($results,  Response::HTTP_OK);

        }catch (\Exception $e) {           
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao resgatar as partidas.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
