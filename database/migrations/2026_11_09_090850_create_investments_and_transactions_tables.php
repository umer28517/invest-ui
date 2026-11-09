<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('balance', 14, 2)->default(0.00)->after('is_active');
            $table->decimal('withdrawn_total', 14, 2)->default(0.00)->after('balance');
            $table->timestamp('locked_until')->nullable()->after('withdrawn_total');
            $table->decimal('active_daily_rate', 5, 2)->default(0.00)->after('locked_until');
            $table->foreignId('active_package_id')->nullable()->after('active_daily_rate')->constrained('packages')->nullOnDelete();
        });

        Schema::create('deposit_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 14, 2);
            $table->decimal('daily_rate', 5, 2);
            $table->string('payment_method')->default('Binance Pay');
            $table->string('binance_pay_id')->nullable();
            $table->string('transaction_proof')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });

        Schema::create('yield_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('starting_balance', 14, 2);
            $table->decimal('rate_percent', 5, 2);
            $table->decimal('profit_earned', 14, 2);
            $table->decimal('new_balance', 14, 2);
            $table->timestamps();
        });

        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 14, 2);
            $table->string('payout_method')->default('Binance Pay ID');
            $table->string('destination_account');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
        Schema::dropIfExists('yield_distributions');
        Schema::dropIfExists('deposit_requests');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['active_package_id']);
            $table->dropColumn(['balance', 'withdrawn_total', 'locked_until', 'active_daily_rate', 'active_package_id']);
        });
    }
};
