<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitikRusaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titik_rusaks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_admin');
            $table->geometry('geometry');
            $table->string('nama_jalan', 50);
            $table->string('foto');
            $table->text('keterangan')->nullable();
            $table->string('status', 25);
            $table->timestamps();
        });
        Schema::table('titik_rusaks', function ($table) {
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
        Schema::dropIfExists('titik_rusaks');
    }
}
