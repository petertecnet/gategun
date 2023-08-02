<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $fillable = [
        'event_id',
        'user_id',
        'comment',
        'rating',
    ];

    // Relação com o modelo Event (Evento)
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relação com o usuário (um comentário pertence a um usuário)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
