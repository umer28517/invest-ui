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
        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->decimal('fee_percent', 5, 2)->default(0.00)->after('amount');
            $table->decimal('fee_amount', 14, 2)->default(0.00)->after('fee_percent');
            $table->decimal('net_amount', 14, 2)->default(0.00)->after('fee_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('withdrawal_requests', function (Blueprint $table) {
            $table->dropColumn(['fee_percent', 'fee_amount', 'net_amount']);
        });
    }
};
