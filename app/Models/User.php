<?php

namespace App\Models;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Passport;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'mobile',
        'national_id',
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
            'mobile_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @throws AuthenticationException
     */
    public function attempt(Request $request): string
    {
        Passport::personalAccessTokensExpireIn(now()->addHours(2));
        if ($this->id) {
            $user = $this;
        } else {
            $user = self::whereMobile($request->mobile)->firstOr(fn() => self::notFound());
        }
        if (Hash::check($request->password, $user->password)) {
            return $user->createToken("{$request->ip()} | $request->username | {$request->server->get('HTTP_USER_AGENT')}")->accessToken;
        }
        throw new AuthenticationException(trans('message.not_found_user'));
    }

    /**
     * @throws AuthenticationException
     */
    protected static function notFound(): void
    {
        throw new AuthenticationException(trans('message.not_found_user'));
    }
}
