<?php

namespace App\Services\Contract\Rules;

use App\Models\Contract;

interface ContractRuleInterface
{
    public function apply(
        Contract $contract,
        float $total
    ): float;
}
