<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RealState;
use App\Repository\RealStateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RealStateSearchController extends Controller
{
    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index(Request $request) : JsonResponse
    {
        $repository = new RealStateRepository($this->realState);

        if($request->has('coditions')) {
            $repository->selectCoditions($request->get('coditions'));
        }

        if($request->has('fields')) {
            $repository->selectFilter($request->get('fields'));
        }


        return response()->json([
            'data' => $repository->getResult()->paginate('10')
        ],200);
    }


    public function show(int $id)
    {
        //
    }
}
