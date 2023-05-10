<?php

namespace App\Http\Controllers;

use App\Repositories\MatchRepository;
use App\Repositories\StandingRepository;
use App\Services\PredictionService;

class PredictionController extends Controller
{
    private $standingRepository;
    private $matchRepository;

    public function __construct(StandingRepository $standingRepository, MatchRepository $matchRepository)
    {
        $this->standingRepository = $standingRepository;
        $this->matchRepository    = $matchRepository;
    }

    public function getPrediction()
    {
        $chart = (new PredictionService($this->standingRepository, $this->matchRepository))->getPrediction();
        return response()->json([
            'status' => 'ok',
            'items' => $chart
        ], 200);
    }
}
