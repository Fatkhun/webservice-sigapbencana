<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusBencanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_status_bencana', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('tabel_admin_bpbd', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('user_id')->foreign('user_id')
                    ->references('id')->on('users')->default(1);
            $table->timestamps();
        });

        Schema::create('tabel_admin_sar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('user_id')->foreign('user_id')
                    ->references('id')->on('users')->default(1);
            $table->timestamps();
        });

        Schema::create('tabel_kategori_bencana', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('tabel_kondisi_bencana', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('tabel_kabupaten', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('tabel_users_role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('tabel_desa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('kabupaten_id')->foreign('kabupaten_id')
                    ->references('id')->on('tabel_kabupaten')->default(1);
            $table->timestamps();
        });

        Schema::create('tabel_bencana', function (Blueprint $table) {
            $table->increments('id');
            $table->text('alamat');
            $table->integer('luka_luka');
            $table->integer('belum_ditemukan');
            $table->integer('mengungsi');
            $table->integer('meninggal');
            $table->string('users_id')->foreign('users_id')
                    ->references('id')->on('users')->default(1);
            $table->string('kategori_id')->foreign('kategori_id')
                    ->references('id')->on('tabel_kategori_bencana')->default(1);
            $table->string('status_id')->foreign('status_id')
                    ->references('id')->on('tabel_status_bencana')->default(1);
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
        Schema::dropIfExists('tabel_status_bencana');
        Schema::dropIfExists('tabel_admin_bpbd');
        Schema::dropIfExists('tabel_admin_sar');
        Schema::dropIfExists('tabel_kategori_bencana');
        Schema::dropIfExists('tabel_kondisi_bencana');
        Schema::dropIfExists('tabel_kabupaten');
        Schema::dropIfExists('tabel_users_role');
        Schema::dropIfExists('tabel_desa');
        Schema::dropIfExists('tabel_bencana');
    }
}
