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
       Schema::create('installments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('sale_id')->constrained('sales')->onDelete('cascade'); // مش client_id مباشرة
    $table->decimal('amount', 10, 2);
    $table->date('due_date');
    $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
    $table->text('notes')->nullable();
    $table->string('receipt_number')->nullable();
    $table->foreignId('created_by')->nullable() ->constrained('users')->onDelete('cascade'); // مين سجل القسط
    $table->timestamps();
        $table->softDeletes();
        $table->index(['sale_id', 'due_date', 'status']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
