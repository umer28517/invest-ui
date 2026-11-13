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
        // 1. Add trade profit range fields to packages table
        Schema::table('packages', function (Blueprint $table) {
            $table->decimal('min_trade_profit_percent', 6, 2)->default(2.00)->after('referral_commission_percent');
            $table->decimal('max_trade_profit_percent', 6, 2)->default(2.50)->after('min_trade_profit_percent');
        });

        // 2. Add balance freezing and trade timer tracking to users table
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('frozen_balance', 14, 2)->default(0.00)->after('balance');
            $table->timestamp('trade_active_until')->nullable()->after('locked_until');
            $table->timestamp('next_trade_available_at')->nullable()->after('trade_active_until');
        });

        // 3. Create trade_sessions table to record history of every 30m trade execution
        Schema::create('trade_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('amount', 14, 2);
            $table->decimal('rate_percent', 6, 2);
            $table->decimal('profit_earned', 14, 2)->default(0.00);
            $table->timestamp('started_at');
            $table->timestamp('completes_at');
            $table->timestamp('settled_at')->nullable();
            $table->string('status')->default('running'); // running, settled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_sessions');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['frozen_balance', 'trade_active_until', 'next_trade_available_at']);
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['min_trade_profit_percent', 'max_trade_profit_percent']);
        });
    }
};
