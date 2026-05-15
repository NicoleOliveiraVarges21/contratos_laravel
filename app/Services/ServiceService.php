<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ServiceService
{
    public function paginate(): LengthAwarePaginator
    {
        return Service::query()
            ->latest()
            ->paginate(10);
    }

    public function create(array $data): Service
    {
        return Service::query()->create($data);
    }

    public function update(Service $service, array $data): Service
    {
        $service->update($data);

        return $service->refresh();
    }

    public function delete(Service $service): void
    {
        $service->delete();
    }
}
