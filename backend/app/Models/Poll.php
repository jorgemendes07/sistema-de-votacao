<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relação com as opções
    public function options()
    {
        return $this->hasMany(PollOption::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Verificar se está ativa
    public function isActive(): bool
    {
        $now = now();
        return $this->start_date <= $now && $this->end_date >= $now;
    }

    // Atualizar status automaticamente
    public function getStatusAttribute(): string
    {
        $now = now();

        if ($now < $this->start_date) {
            return 'não iniciada';
        }

        if ($now > $this->end_date) {
            return 'finalizada';
        }

        return 'em andamento';
    }
}