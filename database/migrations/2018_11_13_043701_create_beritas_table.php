<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeritasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_berita', function (Blueprint $table) {
            $table->increments('id');
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('bencana_id')->foreign('bencana_id')
                    ->references('id')->on('tabel_bencana')->default(1);
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
        Schema::dropIfExists('tabel_berita');
    }
}
