<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ToAiController extends Controller
{
    public function index(Request $request)
    {
        $datePrimite = json_decode($request->getContent(), true);
        $client = new Client([
            'verify' => false,
        ]);
        
        //$cheie = "sk-proj-xpIJWGzxl6ESur6P3kg7T3BlbkFJgRbkVCBVquTBlcaBmwDh";
        $cheie = "sk-proj-NCUIHllr0dc78SJoSwJMT3BlbkFJb6poJ6kswl7JCmqyjC9B";
        $adresa = "https://api.openai.com/v1/engines/gpt-3.5-turbo-instruct/completions";
        $antete = ["Authorization" => "Bearer " . $cheie];
        $tari = [];

        foreach ($datePrimite["allJobPostings"] as $jp) {
            foreach ($jp["hiringOrganization"] as $organization) {
                array_push($tari, $organization["address"]);
            }
        }

        $prompt = "Create a story with the following countries, ignoring 'testAdress' : " . implode(", ", $tari) . ".";
        $date = ["prompt" => $prompt, "max_tokens" => 500];

        try {
            $cerere = $client->post($adresa, [
                "headers" => $antete,
                "json" => $date,
            ]);
            $raspuns = $cerere->getBody();
            $raspunsDeserializat = json_decode($raspuns);
            $poveste = $raspunsDeserializat->choices[0]->text;

            return response($poveste)->header("Content-Type", "application/json");
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
