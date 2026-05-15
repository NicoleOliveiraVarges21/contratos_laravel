<?php

namespace App\Policies;

use App\Models\ContractItem;
use App\Models\User;

class ContractItemPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(
        ?User $user,
        ContractItem $contractItem
    ): bool {
        return true;
    }

    public function update(
        ?User $user,
        ContractItem $contractItem
    ): bool {
        return $contractItem->contract->status !== 'cancelled';
    }

    public function delete(
        ?User $user,
        ContractItem $contractItem
    ): bool {
        return $contractItem->contract->status !== 'cancelled';
    }
}
