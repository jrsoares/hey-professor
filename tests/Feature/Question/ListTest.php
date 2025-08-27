<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should return a list of questions', function () {
    $user = User::factory()->create();
    actingAs($user);
    $question = Question::factory()->count(5)->create();
    $response = get(route('dashboard'));

    foreach ($question as $q) {
        $response->assertSee($q->question);
    }
});
