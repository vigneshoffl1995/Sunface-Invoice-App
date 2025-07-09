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
        Schema::table('invoice_items', function (Blueprint $table) {
            if (Schema::hasColumn('invoice_items', 'service_id')) {
        $table->dropForeign(['service_id']);
        $table->dropColumn('service_id');
         }
          if (!Schema::hasColumn('invoice_items', 'activity')) {
        $table->string('activity');
         }
          if (!Schema::hasColumn('invoice_items', 'hsn_id')) {
        $table->foreignId('hsn_id')->constrained('hsns')->onDelete('cascade');
         }
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
        $table->dropForeign(['hsn_id']);
        $table->dropColumn('hsn_id');
        $table->dropColumn('activity');
        $table->foreignId('service_id')->constrained()->onDelete('cascade');
    });
    }
};
