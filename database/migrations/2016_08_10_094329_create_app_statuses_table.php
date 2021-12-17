<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAppStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('board_id')->unsigned()->nullable();
            $table->string('system_name', 100);
            $table->string('name', 100);
            $table->text('message')->nullable();
            $table->boolean('is_auto')->default(false);
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['system_name', 'is_auto', 'is_default']);

            $table->foreign('board_id')->references('id')->on('boards')
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
        Schema::dropIfExists('app_statuses');
    }
}
