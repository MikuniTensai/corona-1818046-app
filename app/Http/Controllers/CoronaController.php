<?php

namespace App\Http\Controllers;

use App\Charts\CovidChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CoronaController extends Controller
{
    public function chart() {
        $suspects       = collect(Http::get('https://api.covid19api.com/summary')->json());
        $suspectsData   = $suspects->flatten(1);

        $labels = $suspectsData->pluck('Country');
        $data   = $suspectsData->pluck('NewConfirmed');
        $deaths = $suspectsData->pluck('NewDeaths');
        $reco   = $suspectsData->pluck('TotalRecovered');

        $colors = $labels->map(function($item){
            return '#' . substr(md5(mt_rand()), 0, 6);
        });

        $chart = new CovidChart;
        $chart->labels($labels);
        $chart->dataset('Data Kasus Global Terkonfirmasi', 'line', $data)->backgroundColor($colors);;

        $chart2 = new CovidChart;
        $chart2->labels($labels);
        $chart2->dataset('Data Kasus Global Kematian', 'line', $deaths)->backgroundColor($colors);;

        $chart3 = new CovidChart;
        $chart3->labels($labels);
        $chart3->dataset('Data Kasus Global Kematian', 'line', $reco)->backgroundColor($colors);;

        return view('welcome',[
            'chart' => $chart,
            'chart2' => $chart2,
            'chart3' => $chart3,
        ]);
    }
}
