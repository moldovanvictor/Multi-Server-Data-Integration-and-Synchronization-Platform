<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToGraphQlController extends Controller
{
    public function index(Request $request)
    {
        $datePrimite = json_decode($request->getContent(), true);
        $ch = curl_init("http://localhost:3000");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);
        foreach ($datePrimite as $ob) {
            if (
                isset($ob["@type"][0]) &&
                $ob["@type"][0] == "https://schema.org/JobPosting"
            ) {
                $dataPostarii =
                    $ob["https://schema.org/datePosted"][0]["@value"];
                $descriere = $ob["https://schema.org/description"][0]["@value"];
                $tipContract =
                    $ob["https://schema.org/employmentType"][0]["@value"];
                $organizatii = $ob["https://schema.org/hiringOrganization"];
                $titlu = $ob["https://schema.org/title"][0]["@value"];
                $dataExpirare =
                    $ob["https://schema.org/validThrough"][0]["@value"];
                $org = [];
                foreach ($organizatii as $o) {
                    foreach ($datePrimite as $d) {
                        if (isset($d["@id"]) && $o["@id"] == $d["@id"]) {
                            array_push($org, [
                                "name" =>
                                    $d["https://schema.org/name"][0]["@value"],
                                "address" =>
                                    $d["https://schema.org/address"][0][
                                        "@value"
                                    ],
                            ]);
                            break;
                        }
                    }
                }
                $hiringOrganization = json_encode($org, JSON_UNESCAPED_SLASHES);
                $hiringOrganization = str_replace(
                    ["{", "}", ":", ","],
                    ["{ ", " }", ": ", ", "],
                    $hiringOrganization
                );
                $hiringOrganization = preg_replace(
                    '/"([^"]+)"\s*:\s*/',
                    '$1: ',
                    $hiringOrganization
                );
                $query =
                    'mutation {
                    createJobPosting(
                        title: "' .
                    $titlu .
                    '",
                        description: "' .
                    $descriere .
                    '",
                        datePosted: "' .
                    $dataPostarii .
                    '",
                        validThrough: "' .
                    $dataExpirare .
                    '",
                        employmentType: "' .
                    $tipContract .
                    '",
                        hiringOrganization: ' .
                    $hiringOrganization .
                    '
                    ) {
                        title
                        description
                        datePosted
                        validThrough
                        employmentType
                        hiringOrganization
                    }
                }';
                $data = ["query" => $query];
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                $response = curl_exec($ch);
                if (!$response) {
                    die(
                        'Error: "' .
                            curl_error($ch) .
                            '" - Code: ' .
                            curl_errno($ch)
                    );
                }
            }
        }
        curl_close($ch);
        return $response;
    }
}
