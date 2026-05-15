<?php

namespace Tests\Unit\Services;

use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ClientServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function should_create_client(): void
    {
        $service = app(ClientService::class);

        $client = $service->create([
            'name' => 'João',
            'document' => '123456789',
            'email' => 'joao@email.com',
            'status' => 'active',
        ]);

        $this->assertInstanceOf(Client::class, $client);

        $this->assertDatabaseHas('clients', [
            'email' => 'joao@email.com',
        ]);
    }

    #[Test]
    public function should_not_create_client_with_invalid_data(): void
    {
        $this->expectException(QueryException::class);

        $service = app(ClientService::class);

        $service->create([
            'name' => null,
            'document' => null,
            'email' => null,
            'status' => null,
        ]);
    }

    #[Test]
    public function should_update_client(): void
    {
        $service = app(ClientService::class);

        $client = Client::factory()->create();

        $updated = $service->update($client, [
            'name' => 'Novo Nome',
        ]);

        $this->assertEquals(
            'Novo Nome',
            $updated->name
        );
    }

    #[Test]
    public function should_not_update_client_with_invalid_email(): void
    {
        $this->expectException(QueryException::class);

        $service = app(ClientService::class);

        $client = Client::factory()->create();

        $service->update($client, [
            'email' => null,
        ]);
    }

    #[Test]
    public function should_delete_client(): void
    {
        $service = app(ClientService::class);

        $client = Client::factory()->create();

        $service->delete($client);

        $this->assertDatabaseMissing('clients', [
            'id' => $client->id,
        ]);
    }

    #[Test]
    public function should_return_paginated_clients(): void
    {
        $service = app(ClientService::class);

        Client::factory()
            ->count(15)
            ->create();

        $result = $service->paginate();

        $this->assertEquals(
            10,
            count($result->items())
        );
    }
}
