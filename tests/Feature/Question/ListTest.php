<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should return a list of questions', function () {
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
