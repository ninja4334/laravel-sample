<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('state_id')->unsigned();
            $table->string('title');
            $table->string('abbreviation');
            $table->string('address');
            $table->string('email', 60);
            $table->string('phone', 32)->nullable();
            $table->decimal('card_fee', 7, 2)->unsigned()->nullable();
            $table->decimal('bank_fee', 7, 2)->unsigned()->nullable();
            $table->boolean('is_required_card_fee');
            $table->boolean('is_required_bank_fee');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['email', 'is_active', 'deleted_at']);
            $table->unique(['email', 'phone']);

            $table->foreign('state_id')->references('id')->on('states')
                ->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
