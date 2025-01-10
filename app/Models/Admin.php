<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasFactory;

    
    /**
     *
     * @var array
     */
    protected $fillable = [
        'registration_id',
        'name',
        'email',
        'password',
        'email_verified_at',
        'verified',
    ];

        /**
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

        /**
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
