<?php

namespace Tests\Unit\Services;

use App\Models\Client;
use App\Models\Contract;
use App\Services\Contract\ContractService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContractServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function should_create_contract(): void
    {
        $service = app(ContractService::class);

        $client = Client::factory()->create([
            'status' => 'active'
        ]);

        $contract = $service->create([
            'client_id' => $client->id,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'status' => 'active',
        ]);

        $this->assertInstanceOf(
            Contract::class,
            $contract
        );
    }

    #[Test]
    public function should_not_create_contract_without_client(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $service = app(ContractService::class);

        $service->create([
            'client_id' => 999999,
            'status' => 'active',
        ]);
    }

    #[Test]
    public function should_update_contract(): void
    {
        $service = app(ContractService::class);

        $contract = Contract::factory()->create();

        $updated = $service->update($contract, [
            'status' => 'cancelled',
        ]);

        $this->assertEquals(
            'cancelled',
            $updated->status
        );
    }

    #[Test]
    public function should_delete_contract(): void
    {
        $service = app(ContractService::class);

        $contract = Contract::factory()->create();

        $service->delete($contract);

        $this->assertDatabaseMissing('contracts', [
            'id' => $contract->id,
        ]);
    }

    #[Test]
    public function should_return_paginated_contracts(): void
    {
        $service = app(ContractService::class);

        Contract::factory()
            ->count(15)
            ->create();

        $result = $service->paginate();

        $this->assertEquals(
            10,
            count($result->items())
        );
    }
}
