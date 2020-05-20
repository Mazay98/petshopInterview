<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testGetError()
    {
        $resp = $this->get('/get_teams');
        $resp->assertStatus(400);
    }

    public function testNotValidUriParam()
    {
        $resp = $this->get('/get_teams?url_to_endpoint=google.com');
        $resp->assertStatus(400);
    }

    public function testGetEndpoint()
    {
        $resp = $this->get('/get_endpoint');
        $teams = [
            [
                'team' => 'Axiom',
                'scores' => 88
            ],
            [
                'team' => 'BnL',
                'scores' => 65
            ],
            [
                'team' => 'Eva',
                'scores' => 99
            ],
            [
                'team' => 'WALL-E',
                'scores' => 99
            ],
        ];

        $content = json_decode($resp->getContent(),JSON_OBJECT_AS_ARRAY);

        $this->assertEquals($teams, $content);

        $resp->assertStatus(200);
    }

    public function testSuccess()
    {
        $resp = $this->get('/get_teams?url_to_endpoint='.env('APP_URL').'/get_endpoint');
        $content = json_decode($resp->getContent(),JSON_OBJECT_AS_ARRAY);

        $counts = [
          'one'=>0,
          'two'=>0,
          'three'=>0,
          'four'=>0,
        ];

        foreach($content as $team) {
            switch($team['rank']){
                case 1:
                    $counts['one'] = $counts['one'] +1 ;
                    break;
                case 2:
                    $counts['two'] = $counts['two'] +1;
                    break;
                case 3:
                    $counts['three'] = $counts['three'] +1;
                    break;
                case 4:
                    $counts['four'] = $counts['four'] +1;
                    break;
            }
        }

        $need_count = [
            'one'=>2,
            'two'=>0,
            'three'=>1,
            'four'=>1,
        ];

        $this->assertEquals($counts, $need_count);
        $resp->assertStatus(200);
    }
}
