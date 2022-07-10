<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $quizzes = Quiz::all();

        return $this->response($quizzes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreQuizRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreQuizRequest $request): JsonResponse
    {
        $newQuiz = new Quiz([
            'name' => $request->name,
            'description' => $request->description,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ]);
        $newQuiz->save();

        return $this->response($newQuiz);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $quiz = Quiz::with(['questions.answers'])->where('id', $id)->first();
        if (!$quiz) {
            return $this->response("Quiz with id: $id not found", 404, true);
        }

        return $this->response($quiz);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateQuizRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateQuizRequest $request, int $id): JsonResponse
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return $this->response("Quiz with id: $id not found", 404, true);
        }

        $quiz->update($request->all());
        $quiz->save();

        return $this->response($quiz);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $quiz = Quiz::find($id);
        if (!$quiz) {
            return $this->response("Quiz with id: $id not found", 404, true);
        }

        $quiz->delete();

        return $this->response([]);
    }
}
