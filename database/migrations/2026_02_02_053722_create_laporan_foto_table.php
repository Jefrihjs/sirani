<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanFotoTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_foto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_kegiatan_id')
                  ->constrained('laporan_kegiatan')
                  ->onDelete('cascade');
            $table->string('path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_foto');
    }
}

