<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'time',
        'location',
        'price',
        'image',
        'production_id',
        'production_name',
        // Add other relevant attributes here, if any.
    ];

    // ...

    // Relação com as avaliações (um evento pode ter várias avaliações)
    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
    // Relação com a produção (um evento pertence a uma produção)
    public function production(): BelongsTo
    {
        return $this->belongsTo(Production::class);
    }

    // Verifica se o usuário é participante deste evento
    public function isParticipant(User $user): bool
    {
        return $this->participants()->where('user_id', $user->id)->exists();
    }

    // Relação com os participantes (um evento pode ter vários participantes)
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'items', 'event_id', 'user_id');
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

}
