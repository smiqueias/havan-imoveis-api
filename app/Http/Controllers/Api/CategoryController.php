<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use \App\Models\Category;

class CategoryController extends Controller
{
    private Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }


    public function index() : \Illuminate\Http\JsonResponse
    {
        $category = $this->category->query()->paginate(10);
        return response()->json($category,200);
    }

    public function store(CategoryRequest $request) : \Illuminate\Http\JsonResponse
    {
        $data = $request->all();
        try {
            $category = $this->category->query()->create($data);
            return response()->json([
                'data' => [
                    'msg' => 'Categoria registrada com sucesso!'
                ]
            ],201);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }

    public function show( int $id) : \Illuminate\Http\JsonResponse
    {
        try {
            $category = $this->category->query()->findOrFail($id);
            return response()->json([
                'data' => [
                    $category
                ]
            ],200);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }

    public function update(CategoryRequest $request, int $id) : \Illuminate\Http\JsonResponse
    {
        $data = $request->all();
        try {
            $category = $this->category->query()->findOrFail($id);
            $category->query()->update($data);
            return response()->json([
                'data' => [
                    'msg' => 'Categoria atualizada com sucesso!'
                ]
            ],201);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }

    public function destroy(int $id) : \Illuminate\Http\JsonResponse
    {
        try {
            $category = $this->category->query()->findOrFail($id);
            $category->query()->delete();
            return response()->json([
                'data' => [
                    'msg' => 'Categoria deletada com sucesso!'
                ]
            ]);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }

    public function realStates(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            $category = $this->category->query()->findOrFail($id);
            return response()->json([
                'data' => $category->realStates
            ],200);
        } catch (\Exception $exception) {
            $message = new ApiMessages($exception->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }
}
