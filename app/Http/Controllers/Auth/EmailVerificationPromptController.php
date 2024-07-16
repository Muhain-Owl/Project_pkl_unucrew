<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class UsernameVerificationPromptController extends Controller
{
    /**
     * Display the username verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedUsername()
                    ? redirect()->intended(RouteServiceProvider::HOME)
                    : view('auth.verify-username');
    }
}