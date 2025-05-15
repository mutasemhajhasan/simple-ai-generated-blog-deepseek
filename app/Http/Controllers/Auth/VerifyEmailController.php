<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('home'));
        }

        $request->fulfill();

        return redirect()->intended(route('home'));
    }
}
