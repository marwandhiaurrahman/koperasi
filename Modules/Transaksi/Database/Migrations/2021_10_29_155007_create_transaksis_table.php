<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique()->index();
            $table->date('tanggal');
            $table->foreignId('anggota_id')->unsigned()->nullable()->references('id')->on('users');
            $table->string('jenis');
            $table->enum('tipe', ['Debit', 'Kredit']);
            $table->double('nominal')->nullable();
            $table->enum('validasi', ['Sudah', 'Belum', 'Gagal']);
            $table->foreignId('admin_id')->unsigned()->references('id')->on('users');
            $table->text('keterangan');
            $table->timestamps();
            $table->foreign('jenis')->unsigned()->references('kode')->on('jenis_transaksis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
