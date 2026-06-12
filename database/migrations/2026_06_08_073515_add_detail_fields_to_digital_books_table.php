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
        Schema::table('digital_books', function (Blueprint $table) {

            $table->string('kode_buku')->unique()->after('author');

            $table->string('publisher')->nullable();

            $table->year('year')->nullable();

            $table->string('isbn')->nullable();

            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('digital_books', function (Blueprint $table) {
            //
        });
    }
};
