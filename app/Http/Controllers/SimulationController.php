<?php

namespace App\Http\Controllers;

use App\Repositories\MatchRepository;
use App\Repositories\StandingRepository;
use App\Services\MatchSimulationService;

class SimulationController extends Controller
{
    private $standingRepository;
    private $matchRepository;

    public function __construct(StandingRepository $standingRepository, MatchRepository $matchRepository)
    {
        $this->standingRepository = $standingRepository;
        $this->matchRepository    = $matchRepository;
    }

    public function playAll()
    {
        $matches = $this->matchRepository->getAllMatches();
        (new MatchSimulationService($this->standingRepository, $this->matchRepository))->bulkSimulate($matches);
        return response()->json(['status' => 'ok'], 200);
    }


    public function playWeek($week)
    {
        $matches = $this->matchRepository->getMatchesFromWeek($week);
        (new MatchSimulationService($this->standingRepository, $this->matchRepository))->bulkSimulate($matches);
        $result = $this->matchRepository->getFixtureByWeekId($week);

        return response()->json([
            'status' => 'ok',
            'matches' => $result
        ], 201);
    }
}
