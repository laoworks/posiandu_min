<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anak', function (Blueprint $table) {
            $table->string('nik_anak', 16)->primary();
            $table->string('no_kk', 16);
            $table->string('nama_anak', 100);
            $table->string('nama_ayah', 100)->nullable();
            $table->string('nama_ibu', 100)->nullable();
            $table->integer('anak_ke')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tgl_lahir');
            $table->integer('bb_lahir')->nullable(); // gram
            $table->integer('panjang_lahir')->nullable(); // cm
            $table->text('alamat')->nullable();
            $table->string('no_hp_ortu', 15)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anak');
    }
};
