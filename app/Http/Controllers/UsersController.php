<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class UsersController extends Controller
{
    public function userinfo(Request $request)
    {
        return $request->user();
    }

}
