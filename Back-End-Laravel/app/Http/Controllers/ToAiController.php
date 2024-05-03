<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToAiController extends Controller
{
    public function index(Request $request) {
        $datePrimite = json_decode($request->getContent(), true);
        $client=new \GuzzleHttp\Client();
        $cheie = 'sk-proj-xpIJWGzxl6ESur6P3kg7T3BlbkFJgRbkVCBVquTBlcaBmwDh';
        $adresa = 'https://api.openai.com/v1/engines/gpt-3.5-turbo-instruct/completions';
        $antete = [ 'Authorization' => "Bearer " . $cheie ];

        $tari = [];
        foreach ( $datePrimite['allJobPostings'] as $jp ) {
            for ( $i = 0; $i < count( $jp['hiringOrganization'] ); $i++ ) {
                array_push( $tari, $jp['hiringOrganization'][$i]['address'] );
            }
        }

        $prompt = "Create a story with the following countries: " . implode(", ", $tari) . ".";
        $date=['prompt'=>$prompt,'max_tokens'=>500];
        $cerere=$client->postAsync($adresa,["headers"=>$antete,"json"=>$date]);
        $raspuns = $cerere->wait();
        $raspunsDeserializat=json_decode($raspuns->getBody());
        $poveste=$raspunsDeserializat->choices[0]->text;

        return response($poveste)->header('Content-Type', 'application/json');
    }
}
