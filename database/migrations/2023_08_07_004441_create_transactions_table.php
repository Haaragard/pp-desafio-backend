<?php

use App\Models\Account;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->foreignIdFor(Account::class, 'payer_id')->comment('account_id, this one pays');
            $table->foreignIdFor(Account::class, 'payee_id')->comment('account_id, this one receives');
            $table->unsignedBigInteger('amount');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('reproved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
