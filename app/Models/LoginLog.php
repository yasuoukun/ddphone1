<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'user_agent',
        'login_method',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Parse User Agent into friendly device & browser string
     */
    public function getFormattedDeviceAttribute(): string
    {
        $agent = $this->user_agent ?? '';
        if (empty($agent)) {
            return 'อุปกรณ์ไม่ระบุ';
        }

        // Platform detection
        $platform = 'อุปกรณ์อื่น';
        if (preg_match('/iphone/i', $agent)) {
            $platform = '📱 iPhone';
        } elseif (preg_match('/ipad/i', $agent)) {
            $platform = '📱 iPad';
        } elseif (preg_match('/android/i', $agent)) {
            $platform = '📱 Android';
        } elseif (preg_match('/windows/i', $agent)) {
            $platform = '💻 Windows';
        } elseif (preg_match('/macintosh|mac os/i', $agent)) {
            $platform = '💻 Mac';
        } elseif (preg_match('/linux/i', $agent)) {
            $platform = '💻 Linux';
        }

        // Browser detection
        $browser = '';
        if (preg_match('/edg/i', $agent)) {
            $browser = 'Edge';
        } elseif (preg_match('/chrome|crios/i', $agent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/firefox|fxios/i', $agent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/safari/i', $agent)) {
            $browser = 'Safari';
        } elseif (preg_match('/opera|opr/i', $agent)) {
            $browser = 'Opera';
        }

        return $browser ? "{$platform} ({$browser})" : $platform;
    }

    /**
     * Helper to record a login log entry easily
     */
    public static function logAttempt($email, $status = 'successful', $userId = null, $method = 'email')
    {
        try {
            return static::create([
                'user_id' => $userId,
                'email' => $email,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'login_method' => $method,
                'status' => $status,
            ]);
        } catch (\Throwable $e) {
            // Silently fail if DB error to prevent blocking login flow
            return null;
        }
    }
}
