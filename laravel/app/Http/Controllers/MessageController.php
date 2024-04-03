<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function deleteMessage(Request $request) {
        $id = intval($request->id);

        $message = Message::find($id);
        $message->delete();

        return true;
    }
}
