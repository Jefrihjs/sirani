<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKegiatanTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('master_kegiatan_id')->constrained('master_kegiatan');
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('tempat');
            $table->text('uraian');
            $table->json('foto')->nullable();
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('laporan_kegiatan');
    }
}
