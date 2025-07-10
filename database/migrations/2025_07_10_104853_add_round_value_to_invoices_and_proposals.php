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
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('round_value', 10, 2)->nullable()->after('round_total');
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->decimal('round_value', 10, 2)->nullable()->after('round_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('round_value', 10, 2)->nullable()->after('round_total');
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->decimal('round_value', 10, 2)->nullable()->after('round_total');
        });
    }
};
