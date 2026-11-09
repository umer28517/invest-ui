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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('investment_amount', 12, 2)->default(100.00); // Standard investment amount
            $table->decimal('daily_commission_percent', 6, 2)->default(2.50); // Daily commission / ROI %
            $table->decimal('min_withdrawal_limit', 12, 2)->default(10.00); // Minimum withdrawal limit
            $table->decimal('min_investment', 12, 2)->nullable();
            $table->decimal('max_investment', 12, 2)->nullable();
            $table->integer('duration_days')->nullable();
            $table->string('badge')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
