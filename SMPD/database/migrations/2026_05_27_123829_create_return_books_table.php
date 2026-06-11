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
    Schema::create('return_books', function (Blueprint $table) {
        $table->id();
        $table->string('return_code')->unique();
        $table->foreignId('loan_id')->constrained()->cascadeOnDelete();
        $table->date('return_date');
        $table->integer('late_days')->default(0);
        $table->integer('fine_amount')->default(0);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_books');
    }
};
