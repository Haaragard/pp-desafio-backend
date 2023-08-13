<?php

namespace App\Providers;

use App\Services\{
    AccountService,
    CompanyService,
    MockyService,
    PersonService,
    TransactionService,
    UserService,
    WiremockService
};
use App\Services\Contracts\{
    AccountServiceContract,
    CompanyServiceContract,
    MockyServiceContract,
    PersonServiceContract,
    TransactionServiceContract,
    UserServiceContract,
    WiremockServiceContract
};
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserServiceContract::class,
            UserService::class
        );

        $this->app->bind(
            PersonServiceContract::class,
            PersonService::class
        );

        $this->app->bind(
            CompanyServiceContract::class,
            CompanyService::class
        );

        $this->app->bind(
            AccountServiceContract::class,
            AccountService::class
        );

        $this->app->bind(
            TransactionServiceContract::class,
            TransactionService::class
        );

        $this->app->bind(
            MockyServiceContract::class,
            MockyService::class
        );

        $this->app->bind(
            WiremockServiceContract::class,
            WiremockService::class
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            UserServiceContract::class,
            PersonServiceContract::class,
            CompanyServiceContract::class,
            AccountServiceContract::class,
            TransactionServiceContract::class,
            MockyServiceContract::class,
            WiremockServiceContract::class,
        ];
    }
}
