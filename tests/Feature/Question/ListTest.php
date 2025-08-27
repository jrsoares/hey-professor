<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

it('should return a list of question', function () {
    $user = User::factory()->create();
    actingAs($user);
    $questions = Question::factory()->count(5)->create([
        'created_by' => $user->id,
        'question'   => fake()->sentence() . '?',

    ]);
    $response = get(route('dashboard'));

    $response->assertStatus(200);

    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }
});

it('should paginate the result', function () {
    $user = User::factory()->create();
    Question::factory()->count(20)->create();

    actingAs($user);
    get(route('dashboard'))
        ->assertViewHas('questions', fn ($value) => $value instanceof LengthAwarePaginator);
});
