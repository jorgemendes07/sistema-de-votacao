<?php

namespace Tests\Feature;

use App\Models\Poll;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PollApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_list_polls(): void
    {
        Poll::factory()->create()->options()->createMany([
            ['option_text' => 'A', 'votes' => 0],
            ['option_text' => 'B', 'votes' => 0],
        ]);

        $response = $this->getJson('/api/polls');

        $response->assertOk()->assertJsonCount(1, 'data');
    }

    public function test_guests_cannot_create_polls(): void
    {
        $response = $this->postJson('/api/polls', [
            'title' => 'Nova enquete',
            'start_date' => now()->toDateTimeString(),
            'end_date' => now()->addDay()->toDateTimeString(),
            'options' => ['A', 'B'],
        ]);

        $response->assertUnauthorized();
    }

    public function test_authenticated_users_can_create_polls(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/polls', [
            'title' => 'Nova enquete',
            'start_date' => now()->toDateTimeString(),
            'end_date' => now()->addDay()->toDateTimeString(),
            'options' => ['A', 'B'],
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.title', 'Nova enquete')
            ->assertJsonCount(2, 'data.options');

        $this->assertDatabaseHas('polls', ['title' => 'Nova enquete']);
    }

    public function test_guests_cannot_vote_on_a_poll(): void
    {
        $poll = Poll::factory()->create(['start_date' => now()->subDay(), 'end_date' => now()->addDay()]);
        $option = $poll->options()->create(['option_text' => 'A', 'votes' => 0]);
        $poll->options()->create(['option_text' => 'B', 'votes' => 0]);

        $response = $this->postJson("/api/polls/{$poll->id}/vote", [
            'option_id' => $option->id,
        ]);

        $response->assertUnauthorized();
    }

    public function test_authenticated_users_can_vote_on_an_active_poll(): void
    {
        $user = User::factory()->create();
        $poll = Poll::factory()->create(['start_date' => now()->subDay(), 'end_date' => now()->addDay()]);
        $option = $poll->options()->create(['option_text' => 'A', 'votes' => 0]);
        $poll->options()->create(['option_text' => 'B', 'votes' => 0]);

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/polls/{$poll->id}/vote", [
            'option_id' => $option->id,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.options.0.votes', 1)
            ->assertJsonPath('data.options.0.percentage', 100)
            ->assertJsonPath('data.voted_option_id', $option->id);
    }

    public function test_users_cannot_vote_twice_on_the_same_poll(): void
    {
        $user = User::factory()->create();
        $poll = Poll::factory()->create(['start_date' => now()->subDay(), 'end_date' => now()->addDay()]);
        $optionA = $poll->options()->create(['option_text' => 'A', 'votes' => 0]);
        $optionB = $poll->options()->create(['option_text' => 'B', 'votes' => 0]);

        $this->actingAs($user, 'sanctum')->postJson("/api/polls/{$poll->id}/vote", [
            'option_id' => $optionA->id,
        ])->assertOk();

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/polls/{$poll->id}/vote", [
            'option_id' => $optionB->id,
        ]);

        $response->assertStatus(409);
        $this->assertDatabaseHas('poll_options', ['id' => $optionA->id, 'votes' => 1]);
        $this->assertDatabaseHas('poll_options', ['id' => $optionB->id, 'votes' => 0]);
    }

    public function test_users_cannot_vote_on_a_poll_that_is_not_active(): void
    {
        $user = User::factory()->create();
        $poll = Poll::factory()->create(['start_date' => now()->addDay(), 'end_date' => now()->addDays(2)]);
        $option = $poll->options()->create(['option_text' => 'A', 'votes' => 0]);

        $response = $this->actingAs($user, 'sanctum')->postJson("/api/polls/{$poll->id}/vote", [
            'option_id' => $option->id,
        ]);

        $response->assertStatus(422);
        $this->assertDatabaseHas('poll_options', ['id' => $option->id, 'votes' => 0]);
    }

    public function test_guests_cannot_delete_polls(): void
    {
        $poll = Poll::factory()->create();

        $response = $this->deleteJson("/api/polls/{$poll->id}");

        $response->assertUnauthorized();
        $this->assertDatabaseHas('polls', ['id' => $poll->id]);
    }

    public function test_authenticated_users_can_delete_polls(): void
    {
        $user = User::factory()->create();
        $poll = Poll::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->deleteJson("/api/polls/{$poll->id}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('polls', ['id' => $poll->id]);
    }
}
