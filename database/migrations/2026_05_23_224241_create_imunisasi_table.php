<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imunisasi', function (Blueprint $table) {
            $table->id('id_imunisasi');
            $table->date('tgl_penimbangan');
            $table->string('nik_anak', 16);
            $table->integer('usia'); // dalam bulan
            $table->string('jenis_imunisasi', 50);
            $table->timestamps();

            $table->foreign('nik_anak')->references('nik_anak')->on('anak')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imunisasi');
    }
};
