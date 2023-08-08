<?php

namespace App\Providers;

use App\Repositories\{
    AccountRepository,
    CompanyRepository,
    PersonRepository,
    TransactionRepository,
    UserRepository
};
use App\Repositories\Contracts\{
    AccountRepositoryContract,
    CompanyRepositoryContract,
    PersonRepositoryContract,
    TransactionRepositoryContract,
    UserRepositoryContract

};
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryContract::class,
            UserRepository::class
        );

        $this->app->bind(
            PersonRepositoryContract::class,
            PersonRepository::class
        );

        $this->app->bind(
            CompanyRepositoryContract::class,
            CompanyRepository::class
        );

        $this->app->bind(
            AccountRepositoryContract::class,
            AccountRepository::class
        );

        $this->app->bind(
            TransactionRepositoryContract::class,
            TransactionRepository::class
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
            UserRepositoryContract::class,
            PersonRepositoryContract::class,
            CompanyRepositoryContract::class,
            AccountRepositoryContract::class,
            TransactionRepositoryContract::class,
        ];
    }
}
