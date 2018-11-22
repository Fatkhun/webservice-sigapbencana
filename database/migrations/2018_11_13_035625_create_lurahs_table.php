<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLurahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_lurah', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('periode');
            $table->string('image');
            $table->text('alamat');
            $table->string('desa_id')->foreign('desa_id')
                    ->references('id')->on('tabel_desa')->default(1);
            $table->string('user_id')->foreign('user_id')
                ->references('id')->on('users')->default(1);
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
        Schema::dropIfExists('tabel_lurah');
    }
}
