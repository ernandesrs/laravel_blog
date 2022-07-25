<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable;

    public const LEVEL_1 = 1;
    public const LEVEL_5 = 5;
    public const LEVEL_9 = 9;

    public const GENDER_MALE = "m";
    public const GENDER_FEMALE = "f";
    public const GENDER_NONE = "n";

    /**
     * Allowed levels
     *
     * @var array<int>
     */
    public const LEVELS = [self::LEVEL_1, self::LEVEL_5, self::LEVEL_9];

    /**
     * Allowed genders
     *
     * @var array<string>
     */
    public const GENDERS = [self::GENDER_NONE, self::GENDER_FEMALE, self::GENDER_MALE];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
