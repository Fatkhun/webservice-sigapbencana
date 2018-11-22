<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabel_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_id')->foreign('role_id')
                ->references('id')->on('tabel_users_role')->default(1);
            $table->string('nama');
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('api_token');
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
        Schema::dropIfExists('tabel_user');
    }
}
