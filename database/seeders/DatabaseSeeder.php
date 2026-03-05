<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poll;
use App\Models\PollOption;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $poll = Poll::create([
            'title' => 'Enquete teste',
            'start_date' => now(),
            'end_date' => now()->addDays(1),
            'status' => 'não iniciada',
        ]);

        PollOption::create(['poll_id' => $poll->id, 'option_text' => 'Opção 1']);
        PollOption::create(['poll_id' => $poll->id, 'option_text' => 'Opção 2']);
        PollOption::create(['poll_id' => $poll->id, 'option_text' => 'Opção 3']);
    }
}
