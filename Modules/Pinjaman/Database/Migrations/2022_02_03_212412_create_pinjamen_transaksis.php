<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePinjamenTransaksis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjamen_transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pinjaman_id')->unsigned()->references('id')->on('pinjamen')->onDelete('cascade');
            $table->foreignId('transaksi_id')->unsigned()->references('id')->on('transaksis')->onDelete('cascade');
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
        Schema::dropIfExists('pinjamen_transaksis');
    }
}
