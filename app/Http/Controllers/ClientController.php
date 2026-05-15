<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function __construct(
        protected ClientService $clientService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->clientService->paginate()
        );
    }

    public function store(
        StoreClientRequest $request
    ): JsonResponse {
        $client = $this->clientService->create(
            $request->validated()
        );

        return response()->json(
            $client,
            201
        );
    }

    public function show(
        Client $client
    ): JsonResponse {
        return response()->json($client);
    }

    public function update(
        UpdateClientRequest $request,
        Client $client
    ): JsonResponse {
        $this->authorize('update', $client);

        $client = $this->clientService->update(
            $client,
            $request->validated()
        );

        return response()->json($client);
    }

    public function destroy(
        Client $client
    ): JsonResponse {
        $this->authorize('delete', $client);

        $this->clientService->delete($client);

        return response()->json(
            null,
            204
        );
    }
}
