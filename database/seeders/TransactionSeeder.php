<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $accounts = Account::with('user')->get();

        $accounts->each(fn (Account $account) =>
                Transaction::factory()
                ->for($account, 'payer')
                ->for(
                    $accounts->shuffle()
                        ->filter(fn (Account $accountFiltered) =>
                            ($accountFiltered->id != $account->id)
                        )->first(), 'payee'
                )
                ->create()
            );
    }
}