<?php

namespace App\Http\Controllers\admin;

use App\DTO\BrandDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brand\StoreRequest;
use App\Http\Requests\Brand\UpdateRequest;
use App\Services\BrandService;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
    public function __construct(protected BrandService $brandService) {}
    public function index(): JsonResponse {

        return response()->json([
            'status' => 200,
            'data'  =>  $this->brandService->list()
        ],200);

    }
    public function store(StoreRequest $request): JsonResponse {

        $dto    =   BrandDTO::fromArray($request->validated());

        $brand  =   $this->brandService->create($dto);

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Brand created successfully',
            'data'      =>  $brand
        ]);
    }

    public function show(string $id): JsonResponse {
        $brand   = $this->brandService->find($id);

        if(!$brand) {
            return response()->json([
                'status'    =>  404,
                'message'   =>  'Brand not found',
                'data'  =>  []
            ],404);
        }

        return response()->json([
            'status'    =>  200,
            'data'  =>  $brand
        ],200);
    }

    public function update(UpdateRequest $request, string $id): JsonResponse {
        $dto    =   BrandDTO::fromArray($request->validated());
        $brand  =   $this->brandService->update($id,$dto);

        if(!$brand) {
            return response()->json([
                'status'    =>  404,
                'message'   =>  'Brand not found',
                'data'  =>  []
            ],404);
        }

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Brand updated successfully',
            'data'      =>  $brand
        ]);
    }

    public function destroy(string $id): JsonResponse {

        if(!$this->brandService->delete($id)) {
            return response()->json([
                'status'    =>  404,
                'message'   =>  'Brand not found',
                'data'  =>  []
            ],404);
        }

        return response()->json([
            'status'    =>  200,
            'message'   =>  'Brand deleted successfully',
        ]);
    }
}
