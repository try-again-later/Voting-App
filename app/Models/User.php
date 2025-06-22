<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasMany<Idea, $this>
     */
    public function ideas(): HasMany
    {
        return $this->hasMany(Idea::class);
    }

    /**
     * @return BelongsToMany<Idea, $this>
     */
    public function votes(): BelongsToMany
    {
        return $this->belongsToMany(Idea::class, 'votes');
    }

    public function avatar(): string
    {
        $emailHash = md5($this->email);
        return "https://api.dicebear.com/9.x/identicon/jpg?seed={$emailHash}";
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
}
