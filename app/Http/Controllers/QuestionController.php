<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {
        Question::query()->create(request()->validate([
            'question' => ['required', 'string', 'max:1000'],
        ]));

        return to_route('dashboard');
    }
}
