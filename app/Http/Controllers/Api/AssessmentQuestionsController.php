<?php
namespace App\Http\Controllers\Api;

use App\Models\Question;
use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionCollection;

class AssessmentQuestionsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assessment $assessment
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Assessment $assessment)
    {
        $this->authorize('view', $assessment);

        $search = $request->get('search', '');

        $questions = $assessment
            ->questions()
            ->search($search)
            ->latest()
            ->paginate();

        return new QuestionCollection($questions);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assessment $assessment
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Assessment $assessment,
        Question $question
    ) {
        $this->authorize('update', $assessment);

        $assessment->questions()->syncWithoutDetaching([$question->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Assessment $assessment
     * @param \App\Models\Question $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Assessment $assessment,
        Question $question
    ) {
        $this->authorize('update', $assessment);

        $assessment->questions()->detach($question);

        return response()->noContent();
    }
}
