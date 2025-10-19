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
       Schema::create('expenses', function (Blueprint $table) {
    $table->id();
    $table->string('description'); // وصف المصروف (مثال: إيجار مكتب، شراء أثاث)
    $table->decimal('amount', 10, 2); // المبلغ
    $table->date('date'); // تاريخ المصروف
    $table->text('notes')->nullable(); // ملاحظات يمكن تعديلها
    $table->enum('category', ['rent', 'salaries', 'maintenance', 'other'])->default('other'); // نوع المصروف
    $table->foreignId('created_by')->nullable(); // مين سجل المصروف
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
