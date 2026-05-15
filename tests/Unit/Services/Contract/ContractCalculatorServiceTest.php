<?php

namespace Tests\Unit\Services\Contract;

use App\Models\Contract;
use App\Models\ContractItem;
use App\Services\Contract\ContractCalculatorService;
use App\Services\Contract\Rules\QuantityDiscountRule;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContractCalculatorServiceTest extends TestCase
{
    #[Test]
    public function should_calculate_contract_total_with_discount(): void
    {
        $contract = new Contract();

        $contract->setRelation(
            'items',
            collect([
                new ContractItem([
                    'quantity' => 3,
                    'unit_price' => 100,
                ]),
                new ContractItem([
                    'quantity' => 2,
                    'unit_price' => 100,
                ]),
            ])
        );

        $service = new ContractCalculatorService(
            new QuantityDiscountRule()
        );

        $result = $service->calculate($contract);

        $this->assertEquals(450, $result);
    }
}
