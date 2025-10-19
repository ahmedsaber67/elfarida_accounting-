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
        Schema::create('sales', function (Blueprint $table) {
    $table->id();
    $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
    $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
    $table->date('sale_date')->default(now());
    $table->decimal('total_price', 12);
    $table->decimal('down_payment', 12, 2)->default(0);
    $table->decimal('remaining_amount', 12, 2)->default(0);
    $table->integer('installments_count')->default(0);
    $table->enum('installment_type', ['monthly', 'quarterly'])->default('monthly');
    
    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
