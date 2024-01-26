<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kolirt\Ukrposhta\Facade\Ukrposhta;

class UkrPoshtaController extends Controller
{
    public function getCities(Request $request) {
        $city = strval($request->city);
        $cities = Ukrposhta::getCities($city);

        return $cities;
    }

    public function getPostOffices(Request $request) {
        $cityId = intval($request->cityId);
        $zipCode = strval($request->zipCode);


        $offices = Ukrposhta::getPostOfficesByCityIdAndPostCode($cityId, $zipCode);

        return $offices;
    }
}
