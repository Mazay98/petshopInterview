<?php

namespace App\Http\Controllers;

use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;

class TeamController extends Controller {

    public function getTeam(Request $request) {
        $req_url = htmlspecialchars($request->input('url_to_endpoint'));

        if( empty($req_url) ) {
            return response(json_encode('missing params[url_to_endpoint]'), 400);
        }

        try {
            $endpoint_arr = json_decode(file_get_contents($req_url), JSON_OBJECT_AS_ARRAY);
        } catch(\Exception $exception){
            return response(json_encode('not valid uri param'), 400);
        }

        usort($endpoint_arr, $this->sortArray('scores'));
        $endpoint_arr = array_reverse($endpoint_arr);

        $last_score = 0;

        for($i = 0; $i < count($endpoint_arr); $i++) {
            if (!isset($endpoint_arr[$i]['scores'])){
                return response(json_encode('scores not valid'), 400);
            }
            if( $endpoint_arr[$i]['scores'] == $last_score ) {
                $endpoint_arr[$i]['rank'] = $endpoint_arr[$i - 1]['rank'];
            } else {
                $endpoint_arr[$i]['rank'] = $i + 1;
            }
            $last_score = $endpoint_arr[$i]['scores'];
        }

        usort($endpoint_arr, $this->sortArray('rank'));

        return response(json_encode($endpoint_arr));
    }

    public function getEndpoint(){
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

        return response(json_encode($teams));
    }

    private function sortArray($key) {
        return function($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        };
    }
}
