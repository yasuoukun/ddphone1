<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Notifications\ClaimStatusNotification;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Helper to send notification to a user by ID
     */
    public static function sendToUser($userId, $title, $message, $url = null, $image = null)
    {
        if (!$userId) return null;
        $user = User::find($userId);
        if ($user) {
            return $user->notify(new ClaimStatusNotification($title, $message, $url, $image));
        }
        return null;
    }
}
