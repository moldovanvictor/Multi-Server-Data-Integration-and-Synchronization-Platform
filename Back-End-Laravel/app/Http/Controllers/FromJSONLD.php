<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class FromJSONLD extends Controller
{
    public function index(Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost:4000");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        preg_match(
            '/<script type="application\/ld\+json" id="scriptTag">(.*?)<\/script>/s',
            $response,
            $matches
        );
        if (isset($matches[1])) {
            $jsonld = $matches[1];
            header("Content-type:application/json");
            return $jsonld;
        } else {
            return response()->json(["error" => "JSON-LD data not found"], 404);
        }
    }
}
