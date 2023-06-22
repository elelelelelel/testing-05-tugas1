<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class TestController extends Controller
{
    public function index()
    {
        $comparison = new \Atomescrochus\StringSimilarities\Compare();
        $string1 = "Daniel Siahaan";
        $string2 = "Daniel Sibhaan";

        // the functions returns similarity percentage between strings
        $jaroWinkler = $comparison->jaroWinkler($string1, $string2); // JaroWinkler comparison
        $levenshtein = $comparison->levenshtein($string1, $string2); // Levenshtein comparison
        $smg = $comparison->smg($string1, $string2); // Smith Waterman Gotoh comparison
        $similar = $comparison->similarText($string1, $string2); // Using "similar_text()"
        return roundDown($jaroWinkler * 100, 2);
        echo 'Jaro : ' . $jaroWinkler . '<br>';
        echo 'Leven : ' . $levenshtein . '<br>';
        echo 'SMG : ' . $smg . '<br>';
        echo 'Similar : ' . $similar . '<br>';
    }

    public function scrap()
    {
        $url = 'https://www.scopus.com/authid/detail.uri?authorId=35849297000';
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $title = $crawler->filter('title')->first()->text();
        $arr = explode("-", $title);
        $convert_name = explode(',', $arr[1]);
        $scopus_name = $convert_name[1] . ' ' . $convert_name[0];
        $inputName = 'Daniel Oranova Siahaan';
        return $scopus_name;
//        $first = $arr[1];
//        return $first;
    }
}
