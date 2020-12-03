<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Customer;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use App\Policies\CustomerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Customer::class => CustomerPolicy::class,
        Product::class => ProductPolicy::class
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('customer-check-company', [CustomerPolicy::class, 'checkCompany']);

        Gate::define('product-check-company', [ProductPolicy::class, 'checkCompany']);

        Gate::define('update-post', [OrderPolicy::class, 'update']);
        Gate::define('order-check-company', [OrderPolicy::class, 'checkCompany']);
    }
}
