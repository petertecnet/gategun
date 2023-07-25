<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'event_name',
        'production_name',
        'name',
        'type',
        'price',
        'ticket_type',
        'quantity',
        'description',
        // Adicione outros campos relevantes aqui, se houver.
    ];

    // Relação com o model Event (um ingresso pertence a um evento)
    public function event()
    {
        return $this->belongsTo(Event::class);
    }  public function production()
    {
        return $this->belongsTo(Production::class);
    }
}
