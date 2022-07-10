<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $questions = Question::all();

        return $this->response($questions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQuestionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreQuestionRequest $request): \Illuminate\Http\JsonResponse
    {
        $newQuestion = new Question([
            'quiz_id' => $request->quiz_id,
            'text' => $request->text,
            'has_many_answers' => $request->has_many_answers,
        ]);
        $newQuestion->save();

        return $this->response($newQuestion);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $question = Question::with(['answers', 'quiz'])->where('id', $id)->first();
        if (!$question) {
            return $this->response("Question with id: $id not found", 404, true);
        }

        return $this->response($question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateQuestionRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateQuestionRequest $request, int $id): \Illuminate\Http\JsonResponse
    {
        $question = Question::find($id);
        if (!$question) {
            return $this->response("Question with id: $id not found", 404, true);
        }

        $question->update($request->all());
        $question->save();

        return $this->response($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $question = Question::find($id);
        if (!$question) {
            return $this->response("Question with id: $id not found", 404, true);
        }

        $question->delete();

        return $this->response([]);
    }
}
