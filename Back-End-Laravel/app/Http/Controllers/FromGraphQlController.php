<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FromGraphQlController extends Controller
{
    public function index(Request $request)
    {
        $interogare = json_decode($request->getContent(), true);
        $ch = curl_init("http://localhost:3000");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($interogare));
        $response = curl_exec($ch);
        if (!$response) {
            die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
        }
        return $response;
    }
}
