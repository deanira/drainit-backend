<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_masyarakat');
            $table->uuid('id_admin')->nullable();
            $table->uuid('id_petugas')->nullable();
            $table->tinyText('nama_jalan');
            $table->geometry('geometry');
            $table->string('foto');
            $table->string('tipe_pengaduan', 20);
            $table->text('deskripsi_pengaduan');
            $table->string('status_pengaduan', 50);
            $table->text('feedback_masyarakat')->nullable();
            $table->timestamps();
        });
        Schema::table('pengaduans', function ($table) {
            $table->foreign('id_masyarakat')->references('id')->on('masyarakats')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('id_admin')->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('pengaduans');
    }
}
