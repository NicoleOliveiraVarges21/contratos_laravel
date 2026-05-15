<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\Service;

use App\Policies\ClientPolicy;
use App\Policies\ContractPolicy;
use App\Policies\ContractItemPolicy;
use App\Policies\ServicePolicy;
use App\Services\Contract\Rules\ContractRuleInterface;
use App\Services\Contract\Rules\QuantityDiscountRule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ContractRuleInterface::class,
            QuantityDiscountRule::class
        );
    }

    public function boot(): void
    {
        Gate::policy(Client::class, ClientPolicy::class);

        Gate::policy(Service::class, ServicePolicy::class);

        Gate::policy(Contract::class, ContractPolicy::class);

        Gate::policy(
            ContractItem::class,
            ContractItemPolicy::class
        );
    }
}
