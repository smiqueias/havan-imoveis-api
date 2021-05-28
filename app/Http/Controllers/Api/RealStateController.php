<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RealState;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RealStateController extends Controller
{

    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function show($id) {
        try {
            $realState = $this->realState->query()->findOrFail($id);
            return response()->json([
                'data' => [
                    $realState
                ]
            ]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],401);
        }
    }

    public function index()  {
        $realState = $this->realState->paginate('10');
        return response()->json($realState,200);
    }

    public function store(Request $request) {

        $data = $request->all();

        try {
            $realState = $this->realState->query()->create($data);
            return response()->json([
                'data' => [
                    'msg' => 'Imóvel cadastrado com sucesso'
                ]
            ],200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],401);
        }
    }

    public function update($id,Request $request) {

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
            return response()->json(['error' => $exception->getMessage()],401);
        }
    }

    public function destroy($id) {

        try {
            $realState = $this->realState->query()->findOrFail($id);
            $realState->delete();
            return response()->json([
                'data' => [
                    'msg' => 'Imóvel removido com sucesso'
                ]
            ],200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],401);
        }

    }
}
