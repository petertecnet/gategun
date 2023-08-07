<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'description',
        'location',
        'address',
        'image',
        'capacity',
        'user_id',
        'user_name',
    ];

    // Relacionamento com eventos - Uma produção pode ter vários eventos
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // Relacionamento com usuário - Uma produção pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
