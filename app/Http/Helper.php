<?php
use Goutte\Client;

if (!function_exists('bytesForHuman')) {
    /**
     * Human readable file size
     *
     * @param string $bytes
     *
     * @return string $string
     */
    function bytesForHuman($bytes)
    {
        $units = ['B', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 1) . ' ' . $units[$i];
    }
}
if (!function_exists('api_response')) {
    function api_response($success, $message = null, $data = null, $code = 200)
    {
        return response()->json([
            'status' => $success == 1 ? 'success' : 'failed',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}

function file_get_contents_curl($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

if (!function_exists('check_orcid_id')) {
    function check_orcid_id($orcid_id, $inputName)
    {
        $url = 'https://orcid.org/' . $orcid_id;
        $html = file_get_contents_curl($url);

        $doc = new DOMDocument();
        @$doc->loadHTML($html);
        foreach ($doc->getElementsByTagName('meta') as $meta) {
            $metaData[] = array(
                'property' => $meta->getAttribute('property'),
                'content' => $meta->getAttribute('content')
            );
        }

        foreach ($metaData as $meta) {
            if ($meta['property'] == 'og:title') {
                $arr = explode("(", $meta['content'], 2);
                $first = $arr[0];
                $comparison = new \Atomescrochus\StringSimilarities\Compare();
                $similarity = roundDown($comparison->jaroWinkler($first, $inputName) * 100, 2);
                return $similarity;
            }
        }
    }
}

if (!function_exists('check_scopus_url')) {
    function check_scopus_url($url, $inputName)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $title = $crawler->filter('title')->first()->text();
        $arr = explode("-", $title);
        $convert_name = explode(',', $arr[1]);
        $scopus_name = $convert_name[1] . ' ' . $convert_name[0];
        $comparison = new \Atomescrochus\StringSimilarities\Compare();
        $similarity = roundDown($comparison->smg($scopus_name, $inputName) * 100, 2);
        return $similarity;
    }
}

if (!function_exists('check_sinta_url')) {
    function check_sinta_url($url, $inputName)
    {
        $html = file_get_contents_curl($url);
        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $inputName = strtoupper($inputName);
        foreach ($dom->getElementsByTagName('div') as $ptag) {
            if ($ptag->getAttribute('class') == "au-name") {
                similar_text($ptag->nodeValue, $inputName, $percent);
                return $percent;
            }
        }
    }
}
if (!function_exists('roundDown')) {
    function roundDown($decimal, $precision)
    {
        $sign = $decimal > 0 ? 1 : -1;
        $base = pow(10, $precision);
        return floor(abs($decimal) * $base) / $base * $sign;
    }
}
