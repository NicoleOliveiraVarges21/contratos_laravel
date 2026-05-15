<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contract\StoreContractRequest;
use App\Http\Requests\Contract\UpdateContractRequest;

use App\Models\Contract;

use App\Services\Contract\ContractCalculatorService;
use App\Services\Contract\ContractService;

use Illuminate\Http\JsonResponse;

class ContractController extends Controller
{
    public function __construct(
        protected ContractService $contractService,
        protected ContractCalculatorService $calculatorService
    ) {
    }

    public function index(): JsonResponse
    {
        return response()->json(
            $this->contractService->paginate()
        );
    }

    public function store(
        StoreContractRequest $request
    ): JsonResponse {
        $contract = $this->contractService->create(
            $request->validated()
        );

        return response()->json(
            $contract,
            201
        );
    }

    public function show(
        Contract $contract
    ): JsonResponse {
        $contract->load([
            'client',
            'items.service',
        ]);

        return response()->json([
            'contract' => $contract,
            'total' => $this->calculatorService
                ->calculate($contract),
        ]);
    }

    public function update(
        UpdateContractRequest $request,
        Contract $contract
    ): JsonResponse {
        $this->authorize('update', $contract);

        $contract = $this->contractService->update(
            $contract,
            $request->validated()
        );

        return response()->json($contract);
    }

    public function destroy(
        Contract $contract
    ): JsonResponse {
        $this->authorize('delete', $contract);

        $this->contractService->delete($contract);

        return response()->json(
            null,
            204
        );
    }

    public function cancel(
        Contract $contract
    ): JsonResponse {
        $this->authorize('cancel', $contract);

        $contract = $this->contractService
            ->cancel($contract);

        return response()->json($contract);
    }
}
