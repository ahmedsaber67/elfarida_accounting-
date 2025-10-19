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
        Schema::create('cashbox_transactions', function (Blueprint $table) {
    $table->id();
    $table->enum('type', ['revenue', 'expense']); // نوع الحركة
    $table->decimal('amount', 15, 2); // المبلغ
    $table->decimal('balance_after', 15, 2); // الرصيد بعد العملية
    $table->text('notes')->nullable(); // ملاحظات
    $table->date('transaction_date'); // تاريخ العملية
    $table->unsignedBigInteger('source_id')->nullable(); // ID للعملية (إيراد أو مصروف)
    $table->string('source_type')->nullable(); // نوع المصدر (Revenue أو Expense)
    $table->foreignId('created_by')->nullable(); // مين سجل الحركة
    $table->timestamps();
    $table->softDeletes(); // لحفظ حالة الحذف
    $table->index(['transaction_date', 'type']); // فهارس لتحسين الأداء
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashboxes');
    }
};
