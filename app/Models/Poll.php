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
        'status', // não iniciada, em andamento, finalizada
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

    // Verificar se está ativa
    public function isActive(): bool
    {
        $now = now();
        return $this->start_date <= $now && $this->end_date >= $now;
    }

    // Atualizar status automaticamente
    public function updateStatus(): void
    {
        $now = now();
        if ($now < $this->start_date) {
            $this->status = 'não iniciada';
        } elseif ($now > $this->end_date) {
            $this->status = 'finalizada';
        } else {
            $this->status = 'em andamento';
        }
        $this->save();
    }
}