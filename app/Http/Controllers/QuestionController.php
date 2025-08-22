<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {
        Question::query()->create(request()->validate([
            'question' => ['required', 'min:10', function (string $attribute, mixed $value, Closure $fail) {
                if ($value[strlen($value) - 1] !== '?') {
                    $fail('The ' . $attribute . ' must end with a question mark.');
                }
            }],
        ]));

        return to_route('dashboard');
    }
}
