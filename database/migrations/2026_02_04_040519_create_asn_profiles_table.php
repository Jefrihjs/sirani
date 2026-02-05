<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsnProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asn_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('jabatan', 100);
            $table->enum('jenis_jabatan', ['Struktural', 'Fungsional', 'Pelaksana']);

            $table->string('unit_kerja', 150);
            $table->string('unit_teknis', 150)->nullable();

            $table->string('golongan_ruang', 20);
            $table->enum('status_kepegawaian', ['PNS', 'PPPK']);

            $table->foreignId('atasan_id')
                ->nullable()
                ->constrained('users');

            $table->timestamps();

            $table->unique('user_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asn_profiles');
    }
}
