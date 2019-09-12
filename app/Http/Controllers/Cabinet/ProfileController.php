<?php

namespace App\Http\Controllers\Cabinet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        return view('cabinet.profile');
    }

    public function getUser(){
        return response()->json([
            'login' => Auth::user()->name,
            'email' => Auth::user()->email,
            'fullname' => Auth::user()->attributes->fullname,
            'gender' => Auth::user()->attributes->gender,
            'avatar' => Auth::user()->attributes->avatar,
            'birthday' => Auth::user()->attributes->birthday,
        ]);
    }

}
