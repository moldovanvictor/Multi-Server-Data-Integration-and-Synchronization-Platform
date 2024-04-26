<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyRdf;

class ToRdf4jController extends Controller
{
    public function index( Request $request ) {
        if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
            $datePrimite = $request->getContent();
            $dateDecodate = json_decode($datePrimite, true);
            $graph = new \EasyRdf\Graph('http://localhost:8080/rdf4j-server/repositories/idgrafexamen');
            $graph->parse($datePrimite, 'jsonld');
            $turtleData = $graph->serialise('turtle');

            

            // Check if the graph is empty
            // curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/rdf4j-server/repositories/idgrafexamen");
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $response = curl_exec($ch);
            // if ($response != "") {
            //     // If the graph is not empty, clear it
            //     curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/rdf4j-server/repositories/idgrafexamen/statements");
            //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "CLEAR");
            //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //     curl_exec($ch);
            // }
            $sparql = new \EasyRdf\Sparql\Client("http://localhost:8080/rdf4j-server/repositories/idgrafexamen/statements");
            $results = $sparql->insert( $turtleData );
            
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/rdf4j-server/repositories/idgrafexamen/statements");
            // curl_setopt($ch, CURLOPT_POST, true);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $turtleData);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/turtle'));
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // $response = curl_exec($ch);
            // curl_close($ch);
            // return response()->json(['turtleData' => $turtleData]);
            return $turtleData;
        }

    }
}
