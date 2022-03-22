<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembaruanPengaduansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembaruan_pengaduans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_pengaduan');
            $table->uuid('id_petugas');
            $table->string('judul', 100);
            $table->text('deskripsi');
            $table->string('foto');
            $table->timestamp('waktu')->default(now());
            $table->timestamps();
        });
        Schema::table('pembaruan_pengaduans', function ($table) {
            $table->foreign('id_pengaduan')->references('id')->on('pengaduans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_petugas')->references('id')->on('petugas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembaruan_pengaduans');
    }
}
