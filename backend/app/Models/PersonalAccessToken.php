<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Producer extends Model
{

    use HasFactory;
        protected $fillable = [
        'name',
        'image_url',
        'location',
    ];

    // Nome da tabela associada ao modelo
    protected $table = 'Producers';
}
