<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreScoreRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->response('Invalid Credentials', 401, true);
        }

        $accessToken = $user->createToken('accessToken')->plainTextToken;

        return $this->response([
            'user' => $user,
            'token' => $accessToken
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return $this->response([]);
    }

    public function showScore(Request $request, int $id): JsonResponse
    {
        $quiz = $request->user()->completedQuizzes->where('id', $id)->first();
        if (!$quiz) {
            return $this->response("Quiz with id: $id not found", 404, true);
        }

        return $this->response($quiz);
    }

    public function storeScore(StoreScoreRequest $request): JsonResponse
    {
        $request->user()->completedQuizzes()->attach($request->quiz_id, [
            'points' => $request->points
        ]);

        return $this->response($request->user()->completedQuizzes);
    }
}
