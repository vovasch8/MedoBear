<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CookieController extends Controller
{
    public function setCookie() {
        $response = response("MedoBear");
        $response->withCookie();
    }

    public function getCookie() {

    }

    public function deleteCookie() {

    }
}
