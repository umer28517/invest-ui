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
        Schema::table('packages', function (Blueprint $table) {
            $table->decimal('min_investment', 12, 2)->nullable()->default(null)->change();
            $table->decimal('max_investment', 12, 2)->nullable()->default(null)->change();
            $table->integer('duration_days')->nullable()->default(null)->change();
            $table->string('badge')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->decimal('min_investment', 12, 2)->default(50.00)->change();
            $table->integer('duration_days')->default(30)->change();
        });
    }
};
