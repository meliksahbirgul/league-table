<?php

namespace App\Http\Controllers;

use App\Repositories\MatchRepository;
use App\Repositories\StandingRepository;
use App\Services\HomeAndAwayDrawService;
use App\Services\PredictionService;

class HomeController extends Controller
{
    private $standingRepository;
    private $matchRepository;

    public function __construct(StandingRepository $standingRepository, MatchRepository $matchRepository)
    {
        $this->standingRepository = $standingRepository;
        $this->matchRepository    = $matchRepository;
        $this->handle();
    }

    public function handle()
    {
        if (!$this->standingRepository->checkStanding()) {
            $this->standingRepository->createStanding();
        }
        if (!$this->matchRepository->checkFixturesDrawn()) {
            $this->makeFixtures();
        }
    }

    public function index()
    {
        $matches     = $this->matchRepository->getFixture()->groupBy('week_id');
        $predictions = (new PredictionService($this->standingRepository, $this->matchRepository))->getPrediction();

        return view(
            'welcome',
            [
                'standing' => $this->standingRepository->getAllStandings(),
                'weeks' => $this->matchRepository->getWeeks(),
                'matches' => $matches,
                'predictions' => $predictions
            ]
        );

    }

    public function makeFixtures()
    {
        $drawService = new HomeAndAwayDrawService($this->matchRepository->getTeamsId());
        $this->matchRepository->createFixture($drawService->getFixturesPlan());
    }

    public function resetLeague()
    {
        $this->matchRepository->truncateMatches();
        $this->standingRepository->truncateStanding();
        $this->makeFixtures();
        return response()->json(['status' => 'ok'], 200);
    }

    public function getStandings()
    {
        return response()->json($this->standingRepository->getAllStandings());
    }

    public function getFixtures()
    {
        $weeks   = $this->matchRepository->getWeeks();
        $fixture = $this->matchRepository->getFixture()->groupBy('week_id');
        return response()->json(['weeks' => $weeks, 'items' => $fixture]);
    }


}
