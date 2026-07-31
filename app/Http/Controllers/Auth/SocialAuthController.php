<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the OAuth provider authentication page.
     */
    public function redirect($provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect()->route('login')->with('error', 'ระบบรองรับเฉพาะการเข้าสู่ระบบผ่าน Google และ Facebook เท่านั้น');
        }

        // Check if provider credentials are set
        $clientId = config("services.{$provider}.client_id");
        if (empty($clientId)) {
            $providerName = ucfirst($provider);
            return redirect()->route('login')->with('error', "ระบบกำลังอยู่ในช่วงทดสอบ ยังไม่ได้ระบุ {$providerName} Client ID & Secret ในไฟล์ .env ครับ");
        }

        try {
            if ($provider === 'facebook') {
                return Socialite::driver('facebook')->setScopes(['public_profile'])->redirect();
            }
            return Socialite::driver($provider)->redirect();
        } catch (\Throwable $e) {
            return redirect()->route('login')->with('error', "ไม่สามารถเชื่อมต่อไปยังบริการ {$provider} ได้ในขณะนี้: " . $e->getMessage());
        }
    }

    /**
     * Obtain the user information from OAuth provider after approval.
     */
    public function callback($provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect()->route('login')->with('error', 'ระบบไม่รองรับช่องทางนี้');
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')->with('error', "การยืนยันตัวตนผ่าน {$provider} ล้มเหลว หรือยกเลิกการกดยินยอม");
        }

        $email = $socialUser->getEmail();
        $providerId = $socialUser->getId();

        // 1. Search by provider ID first
        $user = User::where("{$provider}_id", $providerId)->first();

        // 2. Search by email if not found by provider ID
        if (!$user && !empty($email)) {
            $user = User::where('email', $email)->first();
        }

        if ($user) {
            // Update social ID & avatar if missing
            $updateData = [];
            if (empty($user->{"{$provider}_id"})) {
                $updateData["{$provider}_id"] = $providerId;
            }
            if (empty($user->avatar) && $socialUser->getAvatar()) {
                $updateData['avatar'] = $socialUser->getAvatar();
            }
            if (!empty($updateData)) {
                $user->update($updateData);
            }
        } else {
            // Create new user if not found
            if (empty($email)) {
                $email = "{$provider}_{$providerId}@ddphone.local";
            }

            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? ('ผู้ใช้งาน ' . ucfirst($provider)),
                'email' => $email,
                'avatar' => $socialUser->getAvatar(),
                "{$provider}_id" => $providerId,
                'password' => null,
            ]);
        }

        Auth::login($user, true);

        // Record successful social login audit log
        \App\Models\LoginLog::logAttempt($user->email, 'successful', $user->id, strtolower($provider));

        // Sanitize intended URL to prevent redirecting to background AJAX polling endpoints (e.g. /messages, /notifications)
        $intended = session('url.intended');
        if ($intended && (
            str_contains($intended, '/messages') ||
            str_contains($intended, 'notification-counts') ||
            str_contains($intended, '/notifications/') ||
            str_contains($intended, 'ajax') ||
            str_contains($intended, '_t=')
        )) {
            session()->forget('url.intended');
        }

        $providerName = ucfirst($provider);
        return redirect()->intended(route('dashboard'))
            ->with('sweet_success', "เข้าสู่ระบบด้วย {$providerName} เรียบร้อยแล้ว ยินดีต้อนรับครับ!");
    }
}
