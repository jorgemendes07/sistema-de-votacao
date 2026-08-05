<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poll;
use App\Models\PollOption;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Enquete 1
        $poll1 = Poll::create([
            'title' => 'Qual modalidade de estudo você prefere?',
            'start_date' => now()->addDays(3),
            'end_date' => now()->addDays(3),
        ]);

        PollOption::create(['poll_id' => $poll1->id, 'option_text' => 'Presencial', 'votes' => 0]);
        PollOption::create(['poll_id' => $poll1->id, 'option_text' => 'Híbrido', 'votes' => 0]);
        PollOption::create(['poll_id' => $poll1->id, 'option_text' => 'Educação à distância', 'votes' => 0]);

        // Enquete 2
        $poll2 = Poll::create([
            'title' => 'Você utiliza ferramentas de IA no seu dia a dia de desenvolvimento?',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDays(2),
        ]);

        PollOption::create(['poll_id' => $poll2->id, 'option_text' => 'Diariamente', 'votes' => 18]);
        PollOption::create(['poll_id' => $poll2->id, 'option_text' => 'Algumas vezes por semana', 'votes' => 7]);
        PollOption::create(['poll_id' => $poll2->id, 'option_text' => 'Raramente', 'votes' => 4]);
        PollOption::create(['poll_id' => $poll2->id, 'option_text' => 'Nunca', 'votes' => 1]);

        // Enquete 3
        $poll3 = Poll::create([
            'title' => 'Qual linguagem de programação você mais utiliza para back-end?',
            'start_date' => now(),
            'end_date' => now()->addDays(4),
        ]);

        PollOption::create(['poll_id' => $poll3->id, 'option_text' => 'Python', 'votes' => 2]);
        PollOption::create(['poll_id' => $poll3->id, 'option_text' => 'PHP', 'votes' => 4]);
        PollOption::create(['poll_id' => $poll3->id, 'option_text' => 'JavaScript', 'votes' => 5]);
        PollOption::create(['poll_id' => $poll3->id, 'option_text' => 'C#', 'votes' => 3]);
        PollOption::create(['poll_id' => $poll3->id, 'option_text' => 'Java', 'votes' => 2]);
        PollOption::create(['poll_id' => $poll3->id, 'option_text' => 'Outra', 'votes' => 2]);
    }
}
