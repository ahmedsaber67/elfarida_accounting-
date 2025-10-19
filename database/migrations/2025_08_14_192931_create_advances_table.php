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
        Schema::create('advances', function (Blueprint $table) {
    $table->id();
    $table->string('title'); // وصف العهدة (مثال: بناء شاليه)
    $table->decimal('amount', 10, 2); // المبلغ المبدئي اللي اتصرف
    $table->string('recipient')->nullable(); // اسم المقاول / الموظف
    $table->text('notes')->nullable(); // ملاحظات إضافية
    $table->enum('status', ['open', 'closed'])->default('open'); // مفتوحة / مغلقة
    $table->date('date')->default(now()); // تاريخ صرف العهدة
    $table->timestamps();
});

    

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advances');
    }
};
