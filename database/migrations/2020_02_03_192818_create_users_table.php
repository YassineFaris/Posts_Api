<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
        $table->engine = 'InnoDB';
        $table->charset = 'utf8';
        $table->collation = 'utf8_unicode_ci';
        $table->bigIncrements('id');
        $table->unsignedBigInteger('id_role');
        $table->string('nom_user', 50)->nullable();
        $table->string('prenom_user', 50)->nullable();
        $table->string('phone_user', 20)->unique();
        $table->string('email_user', 80)->unique();
        $table->string('password_user', 255);
        $table->foreign('id_role')->references('id')->on('roles');
        $table->timestamps();
        $table->softDeletes();
    });

    Schema::enableForeignKeyConstraints();
  }
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
