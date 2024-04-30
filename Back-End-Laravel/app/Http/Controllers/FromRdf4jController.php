<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyRdf;

class FromRdf4jController extends Controller
{
    public function index( Request $request ) {
        if ( $_SERVER['REQUEST_METHOD'] === 'GET' ) {
            // $sparql = new \EasyRdf\Sparql\Client("http://localhost:8080/rdf4j-server/repositories/idgrafexamen");
            // $results = $sparql->query( "SELECT ?subject ?predicate ?object WHERE {?subject ?predicate ?object}" );
            // return $results;
            $client = new \EasyRdf\Sparql\Client("http://localhost:8080/rdf4j-server/repositories/idgrafexamen");
            $interogare = 'CONSTRUCT { ?subject ?predicate ?object } WHERE { ?subject ?predicate ?object }';
            $subgraf = $client->query( $interogare );
            $serializator = new \EasyRdf\Serialiser\JsonLd();
            $dateJsonLd = $serializator->serialise( $subgraf, 'jsonld' ); 
            return $dateJsonLd;
        }
    }
    
}
?>