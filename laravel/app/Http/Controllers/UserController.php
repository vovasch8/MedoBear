<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function changeUserRole(Request $request) {
        $id = intval($request->id);
        $user = User::find($id);

        $user->role = strval($request->value);
        $user->save();

        return true;
    }
}
