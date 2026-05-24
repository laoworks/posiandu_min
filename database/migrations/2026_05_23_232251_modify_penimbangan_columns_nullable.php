<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penimbangan', function (Blueprint $table) {
            // Ubah kolom menjadi nullable
            $table->date('tgl_penimbangan')->nullable()->change();
            $table->integer('usia')->nullable()->change();
            $table->double('berat_badan')->nullable()->change();
            $table->enum('keterangan', ['naik', 'tetap', 'turun'])->nullable()->change();
            $table->string('status_gizi', 20)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('penimbangan', function (Blueprint $table) {
            // Kembalikan ke NOT NULL
            $table->date('tgl_penimbangan')->nullable(false)->change();
            $table->integer('usia')->nullable(false)->change();
            $table->double('berat_badan')->nullable(false)->change();
            $table->enum('keterangan', ['naik', 'tetap', 'turun'])->nullable(false)->change();
            $table->string('status_gizi', 20)->nullable(false)->change();
        });
    }
};
