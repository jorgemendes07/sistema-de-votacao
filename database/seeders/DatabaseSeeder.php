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
            'title' => 'Qual o melhor modelo de estudo?',
            'start_date' => now()->subDays(3),
            'end_date' => now()->addDays(3),
        ]);

        PollOption::create(['poll_id' => $poll1->id, 'option_text' => 'Presencial', 'votes' => 4]);
        PollOption::create(['poll_id' => $poll1->id, 'option_text' => 'Híbrido', 'votes' => 1]);
        PollOption::create(['poll_id' => $poll1->id, 'option_text' => 'Educação à distância', 'votes' => 3]);

        // Enquete 2
        $poll2 = Poll::create([
            'title' => 'Qual banda não pode faltar no rock in rio?',
            'start_date' => now()->subDays(10),
            'end_date' => now()->subDays(2),
        ]);

        PollOption::create(['poll_id' => $poll2->id, 'option_text' => 'Metallica', 'votes' => 12]);
        PollOption::create(['poll_id' => $poll2->id, 'option_text' => 'Iron Maiden', 'votes' => 8]);
        PollOption::create(['poll_id' => $poll2->id, 'option_text' => 'Megadeth', 'votes' => 3]);
        PollOption::create(['poll_id' => $poll2->id, 'option_text' => 'AC/DC', 'votes' => 5]);

        // Enquete 3
        $poll3 = Poll::create([
            'title' => 'Qual linguagem de programação você utiliza para back end atualmente?',
            'start_date' => now(),
            'end_date' => now()->addDays(4),
        ]);

        PollOption::create(['poll_id' => $poll3->id, 'option_text' => 'Python', 'votes' => 2]);
        PollOption::create(['poll_id' => $poll3->id, 'option_text' => 'PHP', 'votes' => 4]);
        PollOption::create(['poll_id' => $poll3->id, 'option_text' => 'JavaScript', 'votes' => 5]);
        PollOption::create(['poll_id' => $poll3->id, 'option_text' => 'C#', 'votes' => 3]);
        PollOption::create(['poll_id' => $poll3->id, 'option_text' => 'Java', 'votes' => 2]);

        // Enquete 4
        $poll4 = Poll::create([
            'title' => 'Qual o melhor pet?',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(10),
        ]);

        PollOption::create(['poll_id' => $poll4->id, 'option_text' => 'Gato']);
        PollOption::create(['poll_id' => $poll4->id, 'option_text' => 'Cachorro']);
        PollOption::create(['poll_id' => $poll4->id, 'option_text' => 'Peixe']);
        PollOption::create(['poll_id' => $poll4->id, 'option_text' => 'Pássaro']);
    }
}
