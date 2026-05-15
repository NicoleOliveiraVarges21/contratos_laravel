<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    public function __construct(
        protected ServiceService $serviceService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->serviceService->paginate()
        );
    }

    public function store(
        StoreServiceRequest $request
    ): JsonResponse {
        $service = $this->serviceService->create(
            $request->validated()
        );

        return response()->json(
            $service,
            201
        );
    }

    public function show(
        Service $service
    ): JsonResponse {
        return response()->json($service);
    }

    public function update(
        UpdateServiceRequest $request,
        Service $service
    ): JsonResponse {
        $this->authorize('update', $service);

        $service = $this->serviceService->update(
            $service,
            $request->validated()
        );

        return response()->json($service);
    }

    public function destroy(
        Service $service
    ): JsonResponse {
        $this->authorize('delete', $service);

        $this->serviceService->delete($service);

        return response()->json(
            null,
            204
        );
    }
}
