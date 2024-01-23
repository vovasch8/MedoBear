<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NovaPoshtaController extends Controller
{
    public function sendRequest($model, $method, $params, $methodRequest = "GET") {
        $curl = curl_init();

        $str_params = [];

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $str_params[] = '"' . $key . '": "' . $value . '"';
            }
            $str_params = implode(', ', $str_params);
        }

        $abc = '{
               "apiKey": "' . config("app.api_key_novaposhta") . '",
               "modelName": "' . $model . '",
               "calledMethod": "' . $method . '",
               "methodProperties": {
                    ' . $str_params . '
               }
            }';

        curl_setopt_array($curl, array(
            CURLOPT_URL => config("app.api_url_novaposhta"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $methodRequest,
            CURLOPT_POSTFIELDS =>'{
               "apiKey": "' . config("app.api_key_novaposhta") . '",
               "modelName": "' . $model . '",
               "calledMethod": "' . $method . '",
               "methodProperties": {
                    ' . $str_params . '
               }
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }

    public function getCities(Request $request) {
        $cityName = strval($request->city);

        $cities = $this->sendRequest("Address", "searchSettlements",
            [
                "CityName" => $cityName,
                "Limit" => 100,
                "Page" => 1
            ]);

        return $cities;
    }

    public function getWarehouses(Request $request) {
        $cityName = strval($request->city);
        $cityRef = strval($request->cityRef);
        $findByString = strval($request->warehouse);

        $warehouses = $this->sendRequest("Address", "getWarehouses",
            [
                "CityName" => $cityName,
                "CityRef" => $cityRef,
                "FindByString" => $findByString,
                "Limit" => 100,
                "Page" => 1,
                "Language" => "UA"
            ]);

        return $warehouses;
    }
}
