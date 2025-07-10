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
        // Schema::table('invoices_and_proposals', function (Blueprint $table) {
        //      $table->decimal('round_total', 10, 2)->nullable()->after('total');
        // });
        Schema::table('invoices', function (Blueprint $table) {
        $table->decimal('round_total', 10, 2)->nullable()->after('total');
    });

    Schema::table('proposals', function (Blueprint $table) {
        $table->decimal('round_total', 10, 2)->nullable()->after('total');
    });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('invoices_and_proposals', function (Blueprint $table) {
        //      $table->decimal('round_total', 10, 2)->nullable()->after('total');
        // });
        Schema::table('invoices', function (Blueprint $table) {
        $table->decimal('round_total', 10, 2)->nullable()->after('total');
    });

    Schema::table('proposals', function (Blueprint $table) {
        $table->decimal('round_total', 10, 2)->nullable()->after('total');
    });
    }
};
