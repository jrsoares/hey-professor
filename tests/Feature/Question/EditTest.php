<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to edit a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create();
    actingAs($user);
    get(route('question.edit', $question))->assertSuccessful();
});
