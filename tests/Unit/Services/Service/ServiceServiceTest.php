<?php

namespace Tests\Unit\Services;

use App\Models\Service;
use App\Services\ServiceService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ServiceServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function should_create_service(): void
    {
        $serviceLayer = app(ServiceService::class);

        $service = $serviceLayer->create([
            'name' => 'Consultoria',
            'base_price' => 500,
        ]);

        $this->assertInstanceOf(
            Service::class,
            $service
        );
    }

    #[Test]
    public function should_not_create_service_with_invalid_data(): void
    {
        $this->expectException(QueryException::class);

        $serviceLayer = app(ServiceService::class);

        $serviceLayer->create([
            'name' => null,
            'price' => null,
        ]);
    }

    #[Test]
    public function should_update_service(): void
    {
        $serviceLayer = app(ServiceService::class);

        $service = Service::factory()->create();

        $updated = $serviceLayer->update($service, [
            'name' => 'Atualizado',
        ]);

        $this->assertEquals(
            'Atualizado',
            $updated->name
        );
    }

    #[Test]
    public function should_not_update_service_with_invalid_data(): void
    {
        $this->expectException(QueryException::class);

        $serviceLayer = app(ServiceService::class);

        $service = Service::factory()->create();

        $serviceLayer->update($service, [
            'name' => null,
            'price' => null,
        ]);
    }

    #[Test]
    public function should_delete_service(): void
    {
        $serviceLayer = app(ServiceService::class);

        $service = Service::factory()->create();

        $serviceLayer->delete($service);

        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
        ]);
    }

    #[Test]
    public function should_return_paginated_services(): void
    {
        $serviceLayer = app(ServiceService::class);

        Service::factory()
            ->count(15)
            ->create();

        $result = $serviceLayer->paginate();

        $this->assertEquals(
            10,
            count($result->items())
        );
    }
}
