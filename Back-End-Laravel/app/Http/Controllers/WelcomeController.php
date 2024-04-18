<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class WelcomeController extends Controller
{



// public function index()
// {
//     header("Content-type:application/javascript");
//     $Produs1=["ID"=>"P1","Pret"=>100,"Denumire"=>"Televizor"];
//     $Produs2=["ID"=>"P2","Pret"=>30,"Denumire"=>"Ipod"];
//     $Produse=[$Produs1,$Produs2];
//     $DateRaspuns=["Comanda"=>["Client"=>"PopIon","Produse"=>$Produse]];
//     $NumeFunctieClient=$_GET["callback"];
//     return $NumeFunctieClient."(".json_encode($DateRaspuns).")";
// }
public function index()
{
    // Initialize a cURL session
    $ch = curl_init();

    // Set the URL of the server you want to send a request to (Frontend 2)
    curl_setopt($ch, CURLOPT_URL, "http://localhost:5174");

    // Set the option to return the response as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL session and store the response in $response
    $response = curl_exec($ch);

    // Close the cURL session
    curl_close($ch);

    // Extract JSON-LD data from the response
    preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $response, $matches);

    if (isset($matches[1])) {
        $jsonld = $matches[1];

        // Set the content type to application/javascript
        header("Content-type:application/javascript");

        // Get the callback function name from the GET parameters
        $callback = $_GET["callback"];

        // Return the data in the format you want
        return $callback . "(" . $jsonld . ")";
    } else {
        return response()->json(['error' => 'JSON-LD data not found'], 404);
    }
}



// //return view('welcome');
// }
public function contact()
{
return "conatcteaza-ma";
}
}
