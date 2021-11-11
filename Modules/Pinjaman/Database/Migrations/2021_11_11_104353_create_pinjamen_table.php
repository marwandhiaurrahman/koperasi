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
            $table->date('tanggal');
            $table->foreignId('anggota_id')->unsigned()->references('id')->on('users');
            $table->string('jenis');
            $table->bigInteger('plafon');
            $table->bigInteger('angsuran');
            $table->bigInteger('jasa');
            $table->integer('waktu');
            $table->integer('angsuranke');
            $table->bigInteger('saldo');
            $table->string('validasi');
            $table->foreignId('user_id')->unsigned()->nullable()->references('id')->on('users');
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
