<?php

namespace App\Services\Contract;

use App\Models\Contract;
use App\Services\Contract\Rules\ContractRuleInterface;

class ContractCalculatorService
{
    public function __construct(
        protected ContractRuleInterface $rule
    ) {
    }

    public function calculate(Contract $contract): float
    {
        $total = $contract->items->sum(function ($item) {
            return $item->unit_price * $item->quantity;
        });

        return $this->rule->apply(
            $contract,
            $total
        );
    }
}
