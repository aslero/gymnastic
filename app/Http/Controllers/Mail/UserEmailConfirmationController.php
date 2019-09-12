<?php

namespace App\Http\Controllers\Mail;

use App\Mail\EmailConfirmation;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class UserEmailConfirmationController extends Controller
{
    public function request(User $user){
        return view('home', compact('user'));
    }
    public function sendEmail(User $user, Request $request)
    {
        $token = $user->getEmailConfirmationToken();
        Mail::to($user->email)->send(new EmailConfirmation($user, $token));
        return redirect()->route('home');
    }
    public function confirmEmail(User $user, $token){
        $user_base = User::where('email', $user->email)->where('confirmation_token', $token)->first();
        if (! $user_base) return redirect()->route('home');
        $user_base->confirm();
        return redirect()->route('home');
    }
}
