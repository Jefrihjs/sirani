<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurasiMenitToLaporanKegiatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    if (!Schema::hasColumn('laporan_kegiatan', 'durasi_menit')) {
        Schema::table('laporan_kegiatan', function (Blueprint $table) {
            $table->integer('durasi_menit')
                  ->default(0)
                  ->after('jam_selesai');
        });
    }
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_kegiatan', function (Blueprint $table) {
            //
        });
    }
}
