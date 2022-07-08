<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $answers = Answer::all();

        return $this->response($answers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAnswerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAnswerRequest $request): \Illuminate\Http\JsonResponse
    {
        $newAnswer = new Answer([
            'question_id' => $request->question_id,
            'text' => $request->text,
            'points' => $request->points,
        ]);
        $newAnswer->save();

        return $this->response($newAnswer);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $answer = Answer::with('question')->where('id', $id)->first();
        if (!$answer) {
            return $this->response("Answer with id: $id not found", 404, true);
        }

        return $this->response($answer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnswerRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAnswerRequest $request, int $id): \Illuminate\Http\JsonResponse
    {
        $answer = Answer::find($id);
        if (!$answer) {
            return $this->response("Answer with id: $id not found", 404, true);
        }

        $answer->update($request->all());
        $answer->save();

        return $this->response($answer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $answer = Answer::find($id);
        if (!$answer) {
            return $this->response("Answer with id: $id not found", 404, true);
        }

        $answer->delete();

        return $this->response([]);
    }
}
