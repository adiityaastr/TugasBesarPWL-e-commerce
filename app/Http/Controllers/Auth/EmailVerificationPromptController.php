<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        $user = $request->user();
        $fallbackRoute = ($user && $user->role === 'admin') ? route('admin.dashboard', absolute: false) : route('home', absolute: false);

        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended($fallbackRoute)
                    : view('auth.verify-email');
    }
}
