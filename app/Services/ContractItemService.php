<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\ContractItem;

class ContractItemService
{
    public function create(
        Contract $contract,
        array $data
    ): ContractItem {
        return $contract->items()->create($data);
    }

    public function update(
        ContractItem $item,
        array $data
    ): ContractItem {
        $item->update($data);

        return $item->refresh();
    }

    public function delete(ContractItem $item): void
    {
        $item->delete();
    }
}
