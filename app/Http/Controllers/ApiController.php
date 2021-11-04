<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function api() {
        $suspects       = collect(Http::get('https://api.covid19api.com/countries')->json());
        $suspectsData   = $suspects;

        $Country        = $suspectsData->pluck('Country');

        return view('api', compact([
            'Country',
        ]));
    }
}
