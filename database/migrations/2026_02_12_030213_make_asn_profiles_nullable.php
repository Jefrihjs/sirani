<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeAsnProfilesNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asn_profiles', function (Blueprint $table) {
            $table->enum('jenis_jabatan', ['Struktural','Fungsional','Pelaksana'])->nullable()->change();
            $table->string('unit_kerja',150)->nullable()->change();
            $table->string('golongan_ruang',20)->nullable()->change();
            $table->enum('status_kepegawaian',['PNS','PPPK'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
