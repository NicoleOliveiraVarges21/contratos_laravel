<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contract>
 */
class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),

            'start_date' => now(),

            'end_date' => now()->addMonth(),

            'status' => fake()->randomElement([
                'active',
                'cancelled',
            ]),
        ];
    }
}
