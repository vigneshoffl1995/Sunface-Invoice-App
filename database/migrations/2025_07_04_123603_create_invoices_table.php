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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
        $table->string('invoice_number')->unique();
        $table->foreignId('customer_id')->constrained()->onDelete('cascade');
        $table->date('invoice_date');
        $table->date('valid_until')->nullable();
        $table->decimal('sub_total', 12, 2);
        $table->decimal('cgst', 12, 2)->default(0);
        $table->decimal('sgst', 12, 2)->default(0);
        $table->decimal('total', 12, 2);
        $table->text('notes')->nullable();
        $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
