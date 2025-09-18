<?php

namespace App\Models;



use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function emailVerifications()
{
    return $this->hasMany(EmailVerification::class);
}
public function sendEmailVerificationNotification() 
{
    \Log::info('VERIFICATION EMAIL TRIGGERED for user: ' . $this->email);
    
    
    $code = rand(100000, 999999);
    
    
    EmailVerification::create([
        'user_id' => $this->id,
        'code' => $code,
        'expire_date' => now()->addMinutes(15)
    ]);
    
    
    $this->notify(new \App\Notifications\VerifyEmailWithCode($code));
}
public function sendTwoFactorCode()
{
    $code = rand(100000, 999999);
    
    \App\Models\EmailVerification::create([
        'user_id' => $this->id,
        'code' => $code,
        'expire_date' => now()->addMinutes(10),
    ]);

    $this->notify(new \App\Notifications\TwoFactorCodeNotification($code));
} 
}