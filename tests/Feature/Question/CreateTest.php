<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

it('should be able to create a new question bigger than 255 characters', function () {

    $user = User::factory()->create();
    actingAs($user);
    $request = post(route('question.store'), ['question' => str_repeat('a', 260) . '?']);
    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('a', 260) . '?']);
});

it('should have at least 10 characters', function () {
    $user = User::factory()->create();
    actingAs($user);
    $request = post(route('question.store'), ['question' => str_repeat('a', 8) . '?']);
    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseCount('questions', 0);
});

it('should check if ends with question mark ?', function () {

    $user = User::factory()->create();
    actingAs($user);
    $request = post(route('question.store'), ['question' => str_repeat('a', 10)]);
    $request->assertSessionHasErrors(['question' => 'The question must end with a question mark.']);
    assertDatabaseCount('questions', 0);

});

it('should create as a draft all the time', function () {
    $user = User::factory()->create();
    actingAs($user);
    post(route('question.store'), ['question' => str_repeat('a', 260) . '?']);
    assertDatabaseHas('questions', ['question' => str_repeat('a', 260) . '?', 'draft' => true]);
});

test('only authenticated users can create a new question', function () {
    post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ])->assertRedirect(route('login'));
});

test('question should be unique', function () {
    $user = User::factory()->create();
    actingAs($user);
    Question::factory()->create(['question' => 'Alguma Pergunta?']);
    post(route('question.store'), [
        'question' => 'Alguma Pergunta?',
    ])->assertSessionHasErrors(['question' => 'Pergunta já existe!']);
});
