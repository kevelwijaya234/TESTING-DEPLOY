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
        Schema::create('reservations', function (Blueprint $table) {

            $table->id();

            $table->string('reservation_code')->unique();

            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('book_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->date('reservation_date');

            $table->enum(
                'status',
                [
                    'Menunggu',
                    'Disetujui',
                    'Dipinjam',
                    'Dibatalkan'
                ]
            )->default('Menunggu');

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
