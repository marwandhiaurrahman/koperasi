<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePinjamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjamen', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('name')->unique();
            $table->date('tanggal');
            $table->foreignId('anggota_id')->unsigned()->references('id')->on('users');
            $table->double('plafon');
            $table->enum('tipe', [0, 1]);
            $table->integer('waktu');
            $table->double('angsuran');
            $table->double('jasa');
            $table->double('saldo');
            $table->integer('sisa_angsuran');
            $table->enum('validasi', ['Belum', 'Sudah', 'Ditolak']);
            $table->foreignId('admin_id')->unsigned()->references('id')->on('users');
            $table->text('keterangan');
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
        Schema::dropIfExists('pinjamen');
    }
}
