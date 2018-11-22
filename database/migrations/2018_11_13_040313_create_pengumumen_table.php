<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengumumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_pengumuman', function (Blueprint $table) {
            $table->increments('id');
            $table->text('deskripsi');
            $table->string('kondisi_id')->foreign('kondisi_id')
                    ->references('id')->on('tabel_kondisi_bencana')->default(1);
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
        Schema::dropIfExists('tabel_pengumuman');
    }
}
