<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
use Illuminate\Http\RedirectResponse;

class QuestionController extends Controller
{
    public function index()
    {
        return view('questions.index', [
            'questions' => auth()->user()->questions()->get(),
        ]);
    }
    public function store(): RedirectResponse
    {
        request()->validate([
            'question' => ['required', 'min:10', function (string $attribute, mixed $value, Closure $fail) {
                if ($value[strlen($value) - 1] !== '?') {
                    $fail('The ' . $attribute . ' must end with a question mark.');
                }
            }],
        ]);

        auth()->user()->questions()->create([
            'question' => request()->question,
            'draft'    => true,
        ]);

        return to_route('dashboard');
    }

    public function edit()
    {

    }

    public function destroy(Question $question)
    {
        $this->authorize('destroy', $question);
        $question->delete();

        return back();
    }
}
