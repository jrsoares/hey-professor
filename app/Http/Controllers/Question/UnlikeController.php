<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\{Question};

class UnlikeController extends Controller
{
    public function __invoke(Question $question)
    {
        auth()->user()->unlike($question);

        return back();
    }
}
