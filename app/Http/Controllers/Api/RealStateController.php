<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\Models\RealState;


class RealStateController extends Controller
{

    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $realState = $this->realState->query()->findOrFail($id);
            return response()->json([
                'data' => [
                    $realState
                ]
            ]);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        $realState = $this->realState->paginate('10');
        return response()->json($realState,200);
    }

    public function store(RealStateRequest $request): \Illuminate\Http\JsonResponse
    {

        $data = $request->all();

        try {
            $realState = $this->realState->query()->create($data);

            if ( isset($data['categories']) && count($data['categories']) ) {
                $realState->categories()->sync($data['categories']);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imóvel cadastrado com sucesso'
                ]
            ],200);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }

    public function update($id,RealStateRequest $request): \Illuminate\Http\JsonResponse
    {

        $data = $request->all();

        try {
            $realState = $this->realState->query()->findOrFail($id);
            $realState->update($data);
            return response()->json([
                'data' => [
                    'msg' => 'Imóvel atualizado com sucesso'
                ]
            ],200);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {

        try {
            $realState = $this->realState->query()->findOrFail($id);
            $realState->delete();
            return response()->json([
                'data' => [
                    'msg' => 'Imóvel removido com sucesso'
                ]
            ],200);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }

    }
}
