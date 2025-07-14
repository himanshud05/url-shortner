<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class UrlModel extends Model
{
    protected $fillable = [
        'user_id',
        'original_url',
        'short_url',
        'is_disabled',
        'expires_at',
        'redirect_count',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function getShortCode()
    {
        $shortCode = Str::random(6);
        while (self::where('short_url', $shortCode)->exists()) {
            $shortCode = Str::random(6);    
        }
        return $shortCode;
    }
}
