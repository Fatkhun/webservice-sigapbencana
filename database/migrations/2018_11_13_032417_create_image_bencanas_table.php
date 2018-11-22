<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageBencanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_image_bencana', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');
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
        Schema::dropIfExists('tabel_image_bencana');
    }
}
