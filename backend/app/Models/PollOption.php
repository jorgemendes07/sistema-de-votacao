<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PollOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'poll_id',
        'option_text',
        'votes',
    ];

    // Relação inversa com a enquete
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    // Incrementa votos
    public function vote(): void
    {
        $this->increment('votes');
    }

    // Calcula porcentagem dos votos
    public function percentage(): float
    {
        $totalVotes = $this->poll->options->sum('votes');
        return $totalVotes > 0 ? ($this->votes / $totalVotes) * 100 : 0;
    }
}
