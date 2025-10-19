<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void  // الايرادات 
    {
      Schema::create('revenues', function (Blueprint $table) {
            $table->id();
        $table->string('description')->nullable(); // وصف عام (ممكن نخليه نص ثابت "إيراد")
        $table->decimal('amount', 10, 2);
        $table->date('date');
        $table->enum('source_type', ['sale', 'installment', 'other'])->default('other');
        $table->unsignedBigInteger('source_id')->nullable();
        $table->text('notes')->nullable(); // 🟢 الملاحظات يكتبها اليوزر
        $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
        $table->timestamps();

});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenues');
    }
};
