<?php

namespace App\Services\Contract\Rules;

use App\Models\Contract;

class QuantityDiscountRule implements ContractRuleInterface
{
    public function apply(
        Contract $contract,
        float $total
    ): float {
        $totalItems = $contract->items->sum('quantity');

        if ($totalItems >= 5) {
            return $total * 0.9;
        }

        return $total;
    }
}
