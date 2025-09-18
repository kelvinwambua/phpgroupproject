<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    
    protected $fillable = [
        'code',
        'user_id',
        'expire_date',
    ];

    protected function casts(): array
    {
        return [
            'expire_date' => 'datetime',
        ];
    }
    protected function isExpired(): bool
    {
        return $this->expire_date->isPast();
    }
    protected function getNonExpiredVerificationCodes($userId)
    {
        return self::where('user_id', $userId)
            ->where('expire_date', '>', now())
            ->get();
    }
    


 
}
