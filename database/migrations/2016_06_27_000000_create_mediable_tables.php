<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateMediableTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->string('disk', 32);
            $table->string('directory');
            $table->string('filename');
            $table->string('original_filename')->nullable();
            $table->string('extension', 32);
            $table->string('mime_type', 128);
            $table->string('aggregate_type', 32);
            $table->integer('size')->unsigned();
            $table->timestamps();

            $table->index(['disk', 'directory', 'aggregate_type']);
            $table->unique(['disk', 'directory', 'filename', 'extension']);
        });

        Schema::create('mediables', function (Blueprint $table){
            $table->bigInteger('media_id')->unsigned();
            $table->string('mediable_type');
            $table->integer('mediable_id')->unsigned();
            $table->string('tag');
            $table->integer('order')->unsigned();

            $table->primary(['media_id', 'mediable_type', 'mediable_id', 'tag']);
            $table->index(['mediable_type', 'mediable_id', 'tag', 'order']);

            $table->foreign('media_id')->references('id')->on('media')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mediables');
        Schema::dropIfExists('media');
    }
}
