<?php

namespace Tests\Unit\Services;

use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\Service;
use App\Services\ContractItemService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContractItemServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function should_create_contract_item(): void
    {
        $serviceLayer = app(
            ContractItemService::class
        );

        $contract = Contract::factory()->create();

        $service = Service::factory()->create();

        $item = $serviceLayer->create(
            $contract,
            [
                'service_id' => $service->id,
                'quantity' => 2,
                'unit_price' => 100,
            ]
        );

        $this->assertInstanceOf(
            ContractItem::class,
            $item
        );

        $this->assertDatabaseHas(
            'contract_items',
            [
                'contract_id' => $contract->id,
                'service_id' => $service->id,
                'quantity' => 2,
            ]
        );
    }

    #[Test]
    public function should_not_create_contract_item_with_invalid_data(): void
    {
        $this->expectException(
            QueryException::class
        );

        $serviceLayer = app(
            ContractItemService::class
        );

        $contract = Contract::factory()->create();

        $serviceLayer->create(
            $contract,
            [
                'service_id' => null,
                'quantity' => null,
                'unit_price' => null,
            ]
        );
    }

    #[Test]
    public function should_update_contract_item(): void
    {
        $serviceLayer = app(
            ContractItemService::class
        );

        $item = ContractItem::factory()->create();

        $updated = $serviceLayer->update(
            $item,
            [
                'quantity' => 5,
            ]
        );

        $this->assertEquals(
            5,
            $updated->quantity
        );
    }

    #[Test]
    public function should_not_update_contract_item_with_invalid_data(): void
    {
        $this->expectException(
            QueryException::class
        );

        $serviceLayer = app(
            ContractItemService::class
        );

        $item = ContractItem::factory()->create();

        $serviceLayer->update(
            $item,
            [
                'quantity' => null,
            ]
        );
    }

    #[Test]
    public function should_delete_contract_item(): void
    {
        $serviceLayer = app(
            ContractItemService::class
        );

        $item = ContractItem::factory()->create();

        $serviceLayer->delete($item);

        $this->assertDatabaseMissing(
            'contract_items',
            [
                'id' => $item->id,
            ]
        );
    }
}
