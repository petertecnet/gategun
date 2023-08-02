<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token'
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

    // Relação com os carrinhos (um usuário pode ter vários carrinhos)
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    // Relação com os itens (um usuário pode ter vários itens)
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    // Relação com os eventos (um usuário pode participar de vários eventos)
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'items', 'user_id', 'event_id');
    }
    public function productions(): HasMany
    {
        return $this->hasMany(Production::class);
    }
}
