<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContractItem>
 */
class ContractItemFactory extends Factory
{
    protected $model = ContractItem::class;

    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 10);

        $price = fake()->randomFloat(
            2,
            100,
            1000
        );

        return [
            'contract_id' => Contract::factory(),
            'service_id' => Service::factory(),
            'quantity' => $quantity,
            'unit_price' => $price,
        ];
    }
}
