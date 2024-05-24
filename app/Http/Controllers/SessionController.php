<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function createSession(Request $request): string
    {
        $request->session()->put('User-Id', 'Christian');
        $request->session()->put('Is-Member', 'true');
        return "OK";
    }

    public function getSession(Request $request): string
    {
        $userId = $request->session()->get('User-Id', 'guest');
        $isMember = $request->session()->get('Is-Member', 'false');
        return "User Id : $userId, Is Member : $isMember";
    }
}
