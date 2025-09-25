<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\EloService;

class EloServiceTest extends TestCase
{
    protected EloService $elo;

    protected function setUp(): void
    {
    parent::setUp();
        $this->elo = new EloService();
    }

    /** @test */
    public function it_calculates_expected_score_correctly()
    {
        $expected = $this->elo->expectedScore(1200, 1400);
        $this->assertEqualsWithDelta(0.24, $expected, 0.01);
    }

    /** @test */
    public function it_updates_rating_after_win()
    {
        $newRating = $this->elo->newRating(1200, 0.5, 1);
        $this->assertGreaterThan(1200, $newRating);
    }

    /** @test */
    public function it_updates_rating_after_loss()
    {
        $newRating = $this->elo->newRating(1200, 0.5, 0);
        $this->assertLessThan(1200, $newRating);
    }
}
