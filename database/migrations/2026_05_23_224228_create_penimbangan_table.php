<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penimbangan', function (Blueprint $table) {
            $table->id('id_penimbangan');
            $table->date('tgl_penimbangan');
            $table->string('nik_anak', 16);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->integer('usia'); // dalam bulan
            $table->double('berat_badan'); // dalam kg
            $table->enum('keterangan', ['naik', 'tetap', 'turun']);
            $table->string('status_gizi', 20)->nullable();
            $table->text('saran')->nullable();
            $table->timestamps();

            $table->foreign('nik_anak')->references('nik_anak')->on('anak')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penimbangan');
    }
};
