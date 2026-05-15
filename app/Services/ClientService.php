<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClientService
{
    public function paginate(): LengthAwarePaginator
    {
        return Client::query()
            ->latest()
            ->paginate(10);
    }

    public function getOne(Client $client): Client {
        return $client;
    }

    public function create(array $data): Client
    {
        return Client::query()->create($data);
    }

    public function update(Client $client, array $data): Client
    {
        $client->update($data);

        return $client->refresh();
    }

    public function delete(Client $client): void
    {
        $client->delete();
    }
}
