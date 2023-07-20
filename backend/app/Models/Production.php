<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'image',
        'user_id',
        'user_name',
    ];

    // Relacionamento com eventos - Uma produção pode ter vários eventos
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
