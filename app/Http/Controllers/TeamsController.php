<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

use App\Repositories\Teams\TeamsRepository;

class TeamsController extends Controller
{
    protected TeamsRepository $teamsRepository;

    public function __construct(TeamsRepository $teamsRepository)
    {
        $this->teamsRepository = $teamsRepository;
    }

    public function getTeamById($id){
        try {
            $team = $this->teamsRepository->getTeamById($id);
            return $team
            ? response()->json(['team' => $team], Response::HTTP_OK)
            : response()->json(['error' => 'Time não encontrado'], Response::HTTP_NOT_FOUND);
        
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getTeams(){

        try {
            $teams = $this->teamsRepository->getAllTeams();
            return $teams
            ? response()->json(['teams' => $teams], Response::HTTP_OK)
            : response()->json(['error' => 'nenhum time encontrado'], Response::HTTP_NOT_FOUND);
        
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }



    public function storeTeam(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $success = $this->teamsRepository->storeTeam($request);
            return $success
            ? response()->json(['success' => 'Time criado com sucesso!'], Response::HTTP_CREATED)
            : response()->json(['failure' => 'Erro ao salvar time'], Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
