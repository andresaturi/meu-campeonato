<?php

namespace App\Services;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use App\Repositories\Teams\TeamsRepository;
use App\Repositories\Matches\MatchesRepository;
use App\Repositories\Championships\ChampionshipsRepository;

class MatcheService
{
    protected $teamsRepository;
    protected $matchesRepository;
    protected $championshipsRepository;
    protected $championship;

    public function __construct(
        TeamsRepository $teamsRepository, 
        MatchesRepository $matchesRepository, 
        ChampionshipsRepository $championshipsRepository
    ) {
        $this->teamsRepository = $teamsRepository;
        $this->matchesRepository = $matchesRepository;
        $this->championshipsRepository = $championshipsRepository;
        $this->championship;        
    }

    public function playMatches($championship_id){
       
        $championship = $this->championshipsRepository->getChampionshipById($championship_id);   
       
        if (!$championship) {
            throw new \Exception('Campeonato no encontrado', Response::HTTP_NOT_FOUND);
        }     
      
        $teams = $this->teamsRepository->getAllTeams();
        if (count($teams) !== 8) {
            throw new \Exception('O campeonato requer 8 times para iniciar', Response::HTTP_BAD_REQUEST);
        }    
        $this->championship = $championship;
        $this->matchesRepository->resetMatches($championship->id);
        $this->teamsRepository->resetScore();   
       
        return $this->play(); 
    }
    

    public function play(){

        while(true){
            $activeTeams = $this->teamsRepository->getTeamsActive()->toArray();
            $countTeams = count($activeTeams);
            
            if ($countTeams === 1) {
                $this->thirdPlace();
                return true;                
            }     
            
            $this->setStage($countTeams);
            
            shuffle($activeTeams);           
            $games = $this->createGames($activeTeams);
            $this->processGames($games);           
        }
    }

    protected function processGames(array $games){

        foreach ($games as $game) {         
            $process = new Process(['python3', base_path('teste.py'), json_encode($game)]);
            $process->run();            
            if (!$process->isSuccessful()) {
                throw new RuntimeException($process->getErrorOutput());
            }
            
            $result = json_decode($process->getOutput(), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException('Erro ao processar JSON: ' . json_last_error_msg());
            }            

            $this->setWinner($result);
        }        
    }

    protected function createGames(array $teams): array{

        $games = [];
        for ($i = 0; $i < count($teams); $i += 2) {
            $games[] = [$teams[$i], $teams[$i + 1]];
        }
        return $games;
    }

    public function setWinner(array $teams){

        if ($teams[0]['goals'] > $teams[1]['goals']) {
            $teams[1]['eliminated'] = 1;
        } elseif ($teams[0]['goals'] < $teams[1]['goals']) {
            $teams[0]['eliminated'] = 1;
        } else {
            $this->tieBreaker($teams);
        }

        $teams[0]['balance'] = $teams[0]['goals'] - $teams[1]['goals'];
        $teams[1]['balance'] = $teams[1]['goals'] - $teams[0]['goals'];

        $this->teamsRepository->updateScore($teams);         
        $this->matchesRepository->storeMatche($teams, $this->championship);

    }

    public function tieBreaker(array &$teams){

        if ($teams[0]['extra_time'] > $teams[1]['extra_time']) {
            $teams[1]['eliminated'] = 1;
        } elseif ($teams[0]['extra_time'] < $teams[1]['extra_time']) {
            $teams[0]['eliminated'] = 1;
        } else {
            if ($teams[0]['penalties'] > $teams[1]['penalties']) {
                $teams[1]['eliminated'] = 1;
            } elseif ($teams[0]['penalties'] < $teams[1]['penalties']) {
                $teams[0]['eliminated'] = 1;
            }
        }
        return $teams;
    }

    protected function setStage($countTeams, $third = null){
        if($third){
            $this->championship->stage = 4;
        }
        elseif($countTeams == 8){
            $this->championship->stage = 1;
        }
        elseif($countTeams == 4){
            $this->championship->stage = 2;        
        }
        elseif($countTeams == 2){
            $this->championship->stage = 3;        
        }
    }

    protected function thirdPlace(){
        $eliminatedTeams = $this->matchesRepository->getTeamsthird();
        $teams = [];
        foreach($eliminatedTeams as $eliminatedTeam){  
            $teamId = $eliminatedTeam->home_team_id == $eliminatedTeam->winner_id 
                ? $eliminatedTeam->away_team_id : $eliminatedTeam->home_team_id;
            $teams[] = $this->teamsRepository->getTeamById($teamId);
        }
        shuffle($teams);           
        $games = $this->createGames($teams);
        $this->setStage(0, true);
        $this->processGames($games);           
    }
}
