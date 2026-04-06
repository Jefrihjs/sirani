<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeJabatanNullableOnAsnProfiles extends Migration
{
    public function up()
    {
        Schema::table('asn_profiles', function (Blueprint $table) {
            $table->string('jabatan')->nullable()->change();
            $table->string('jenis_jabatan')->nullable()->change();
            $table->string('unit_kerja')->nullable()->change();
            $table->string('unit_teknis')->nullable()->change();
            $table->string('golongan_ruang')->nullable()->change();
            $table->string('status_kepegawaian')->nullable()->change();
            $table->unsignedBigInteger('atasan_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('asn_profiles', function (Blueprint $table) {
            $table->string('jabatan')->nullable(false)->change();
        });
    }
}

