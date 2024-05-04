<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyRdf;

class ToRdf4jController extends Controller
{
    public function index(Request $request)
    {
        $datePrimite = $request->getContent();
        $dateDecodate = json_decode($datePrimite, true);
        $graph = new \EasyRdf\Graph(
            "http://localhost:8080/rdf4j-server/repositories/idgrafexamen"
        );
        $graph->parse($datePrimite, "jsonld");
        $turtleData = $graph->serialise("turtle");
        $sparql = new \EasyRdf\Sparql\Client(
            "http://localhost:8080/rdf4j-server/repositories/idgrafexamen/statements"
        );
        $results = $sparql->insert($turtleData);
        return $turtleData;
    }
}
