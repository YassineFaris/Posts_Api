<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
  public function up()
  {
    Schema::create('roles', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->charset = 'utf8';
      $table->collation = 'utf8_unicode_ci';
      $table->bigIncrements('id');
      $table->string('libelle_role', 100)->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('roles');
  }
}
