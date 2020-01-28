<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('published_by');
            $table->string('title', 100);
            $table->text('text');
            $table->longText('image');
            $table->boolean('is_published');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('published_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }
  
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
