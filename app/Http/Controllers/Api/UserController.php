<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use \App\Models\User;
use Illuminate\Support\Facades\Validator;

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


        if (!$request->has('password') || !$request->get('password')) {
            $message = new ApiMessages('É necessário informar uma senha para o usuário...');
            return response()->json($message->getMessage(),401);
        }

        Validator::make(
            $data,
            [
                'phone' => 'required',
                'mobile_phone' => 'required'
            ]
        );

        try {
            $data['password'] = bcrypt($data['password']);
            $user = $this->user->query()->create($data);
            $user->userProfile()->create(
                [
                    'phone' => $data['phone'],
                    'mobile_phone' => $data['mobile_phone'],

                ]
            );
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
            $user = $this->user->with('userProfile')->findOrFail($id);
            $user->userProfile->social_networks = unserialize($user->userProfile->social_networks);
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

        if ($request->has('password') && $request->get('password')) {
           $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        try {
            $profile = $data['profile'];
            $profile['social_networks'] = serialize($profile['social_networks']);
            $user = $this->user->query()->findOrFail($id);
            $user->update($data);
            $user->userProfile()->update($profile);
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
