<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'type',
        'price',
        'ticket_type',
        'quantity',
        'description',
        // Adicione outros campos relevantes aqui, se houver.
    ];

    // Relação com o model Event (um ingresso pertence a um evento)
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    // Relação com o model Production (um ingresso pertence a uma produção)
    public function production()
    {
        return $this->belongsTo(Production::class);
    }
}
