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
        Schema::table('reservations', function (Blueprint $table) {

            $table->enum(
                'book_type',
                ['fisik', 'digital']
            )->default('fisik');

            $table->foreignId('digital_book_id')
                ->nullable()
                ->constrained('digital_books')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {

            $table->dropForeign(['digital_book_id']);

            $table->dropColumn([
                'digital_book_id',
                'book_type'
            ]);
        });
    }
};
