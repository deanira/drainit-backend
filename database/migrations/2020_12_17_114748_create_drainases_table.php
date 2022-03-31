<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrainasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drainases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_admin');
            $table->string('nama_jalan', 50);
            $table->float('panjang', 10);
            $table->float('lebar', 10);
            $table->float('kedalaman', 10);
            $table->string('bahan', 15);
            $table->string('kondisi', 15);
            $table->string('arah_alir', 15);
            $table->string('akhir_pembuangan', 20);
            $table->string('foto');
            $table->string('tipe_drainase', 15);
            $table->geometry('geometry');
            $table->timestamps();
        });
        Schema::table('drainases', function ($table) {
            $table->foreign('id_admin')->references('id')->on('admins')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drainases');
    }
}
