<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengumumanDesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_pengumuman_desa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pengumuman_id')->foreign('pengumuman_id')
                    ->references('id')->on('tabel_pengumuman')->default(1);
            $table->string('desa_id')->foreign('desa_id')
                    ->references('id')->on('tabel_desa')->default(1);
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
        Schema::dropIfExists('tabel_pengumuman_desa');
    }
}
