<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePenggajian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penggajian', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tunjangan_pegawai_id')->unsigned();
            $table->foreign('tunjangan_pegawai_id')->references('id')->on('tunjangan_pegawai')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->integer('jumlah_jam_lembur');
            $table->integer('jumlah_uang_lembur');
            $table->integer('gaji_pokok');
            $table->integer('total_gaji');
            $table->date('tanggal_pengambilan');
            $table->boolean('status_pengambilan');
            $table->string('petugas_penerimaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penggajian');
    }
}
