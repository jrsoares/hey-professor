<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;

class QuestionPublishController extends Controller
{
    public function __invoke(Question $question)
    {
        $this->authorize('publish', $question);

        $question->update(['draft' => false]);

        return back();
    }
}
