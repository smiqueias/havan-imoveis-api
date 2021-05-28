<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\User;

class UserController extends Controller
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index() : \Illuminate\Http\JsonResponse
    {
        $user = $this->user->query()->paginate('10');
        return response()->json($user,200);
    }

    public function store(Request $request) : \Illuminate\Http\JsonResponse
    {
        $data = $request->all();

        try {
            $user = $this->user->query()->create($data);
            return response()->json([
                'data' => [
                    'msg' => 'Usuário cadastrado com sucesso'
                ]
            ],200);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }

    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $this->user->query()->findOrFail($id);
            return response()->json([
                'data' => [
                    $user
                ]
            ]);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }


    public function update(Request $request,int $id) : \Illuminate\Http\JsonResponse
    {
        $data = $request->all();

        try {
            $user = $this->user->query()->findOrFail($id);
            $user->update($data);
            return response()->json([
                'data' => [
                    'msg' => 'Usuário atualizado com sucesso'
                ]
            ],200);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }


    public function destroy(int $id) : \Illuminate\Http\JsonResponse
    {
        try {
            $user = $this->user->query()->findOrFail($id);
            $user->query()->delete();
            return response()->json([
                'data' => [
                    'msg' => 'Usuário removido com sucesso'
                ]
            ],200);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }
}
