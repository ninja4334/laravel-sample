<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('board_id')->unsigned();
            $table->integer('type_id')->unsigned()->nullable();
            $table->integer('profession_id')->unsigned()->nullable();
            $table->string('title');
            $table->json('fields')->nullable();
            $table->decimal('price', 11, 2)->unsigned()->nullable();
            $table->integer('renewal_years')->unsigned()->nullable();
            $table->timestamp('renewal_date')->nullable();
            $table->tinyInteger('filling_stage')->unsigned()->nullable();
            $table->text('approved_text')->nullable();
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_active', 'deleted_at']);

            $table->foreign('board_id')->references('id')->on('boards')
                ->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('type_id')->references('id')->on('app_types')
                ->onUpdate('cascade')->onDelete('set null');
            $table->foreign('profession_id')->references('id')->on('board_professions')
                ->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apps');
    }
}
