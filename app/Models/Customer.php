<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable implements MustVerifyEmail
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
        'gender',
        'hobbies',
        'country',
        'profile_picture',
        'role',
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

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getAuthPassword()
    {
        return $this->password;
    }
}
