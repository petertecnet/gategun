<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks'; // Especifique o nome correto da tabela

    protected $fillable = [
        'event_id',
        'rating',
        'comment',
        // Adicione outros campos relevantes aqui, se houver.
    ];

    // Relação com o model Event (um feedback pertence a um evento)
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
