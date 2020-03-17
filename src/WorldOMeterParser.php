<?php


namespace pedrofpmonteiro\Covid19;


use DOMDocument;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

final class WorldOMeterParser
{
    public static function get()
    {

        $response = Http::get("https://www.worldometers.info/coronavirus/");
        $data = new Collection();
        if ($response->successful()) {

            $html = $response->body();

            if (preg_match_all('#<table[^>]+>(.+?)</table>#ims', $html, $matches) && isset($matches[1][0])) {

                $html = $matches[1][0];

                $doc = new DomDocument;
                $internalErrors = libxml_use_internal_errors(true);
                $doc->loadHTML($html);
                libxml_use_internal_errors($internalErrors);

                foreach ($doc->getElementsByTagName('tr') as $tr) {
                    $tds = $tr->getElementsByTagName('td'); // get the columns in this row

                    if ($tds->length >= 4) {
                        $data->add([
                            'Country' => static::convertToString($tds->item(0)->nodeValue),
                            'totalCases' => static::convertToInt($tds->item(1)->nodeValue),
                            'newCases' => static::convertToInt($tds->item(2)->nodeValue),
                            'totalDeaths' => static::convertToInt($tds->item(3)->nodeValue),
                            'newDeaths' => static::convertToInt($tds->item(4)->nodeValue),
                            'totalRecovered' => static::convertToInt($tds->item(5)->nodeValue),
                            'activeCases' => static::convertToInt($tds->item(6)->nodeValue),
                            'seriousCases' => static::convertToInt($tds->item(7)->nodeValue),
                            'total1Mpop' => static::convertToInt($tds->item(8)->nodeValue),
                        ]);
                    }
                }
            }
        }

        return $data;
    }

    private static function convertToString($value)
    {
        return
            Str::of($value)->trim();
    }

    private static function convertToInt($value)
    {
        return
            Str::of($value)
                ->trim()
                ->replace('+', '')
                ->replace(',', '')
                ->whenEmpty(fn($string) => 0);
    }
}