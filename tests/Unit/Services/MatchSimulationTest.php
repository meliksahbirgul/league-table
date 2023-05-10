<?php

namespace Tests\Unit\app\Services\Simulator;

use App\Models\Match;
use App\Repositories\MatchRepository;
use App\Repositories\StandingRepository;
use App\Services\MatchSimulationService;
use Tests\TestCase;

class MatchSimulationTest extends TestCase
{
    private $matchRepository;
    private $standingRepository;
    private $match;

    protected function setUp(): void
    {
        $this->matchRepository = $this->getMockBuilder(MatchRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['generateScore'])
            ->getMock();

        $this->standingRepository = $this->getMockBuilder(StandingRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStandingByTeamId'])
            ->getMock();

        $this->match = $this->getMockBuilder(Match::class)
            ->disableOriginalConstructor()
            ->getMock();

        parent::setUp();
    }


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testSimulateStandingRepositoryCall()
    {

        $this->standingRepository
            ->expects($this->exactly(2));

        $matchSimulator = new MatchSimulationService($this->standingRepository, $this->matchRepository);
        $matchSimulator->simulate($this->match);

    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->matchRepository);
        unset($this->standingRepository);
    }
}
