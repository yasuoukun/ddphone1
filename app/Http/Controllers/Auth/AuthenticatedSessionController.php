<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Record successful login audit log
        if (Auth::check()) {
            \App\Models\LoginLog::logAttempt(Auth::user()->email, 'successful', Auth::id(), 'email');
        }

        $intended = session('url.intended');
        if ($intended && (
            str_contains($intended, '/messages') ||
            str_contains($intended, 'notification-counts') ||
            str_contains($intended, '/notifications/') ||
            str_contains($intended, 'ajax') ||
            str_contains($intended, 'list-ajax') ||
            str_contains($intended, '_t=')
        )) {
            session()->forget('url.intended');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
