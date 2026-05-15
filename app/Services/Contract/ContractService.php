<?php

namespace App\Services\Contract;

use App\Models\Client;
use App\Models\Contract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use DomainException;

class ContractService
{
    public function paginate(): LengthAwarePaginator
    {
        return Contract::query()
            ->with([
                'client',
                'items.service',
            ])
            ->latest()
            ->paginate(10);
    }

    public function create(array $data): Contract
    {
        $client = Client::query()->findOrFail(
            $data['client_id']
        );

        if ($client->status === 'inactive') {
            throw new DomainException(
                'Inactive clients cannot create contracts.'
            );
        }

        return Contract::query()->create($data);
    }

    public function update(
        Contract $contract,
        array $data
    ): Contract {
        $contract->update($data);

        return $contract->refresh();
    }

    public function cancel(Contract $contract): Contract
    {
        $contract->update([
            'status' => 'cancelled',
        ]);

        return $contract->refresh();
    }

    public function delete(Contract $contract): void
    {
        $contract->delete();
    }
}
