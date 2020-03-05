<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimelogBreaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timelog_breaks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('timelog_id')->unsigned();
            $table->dateTime('break_start')->nullable();
            $table->dateTime('break_end')->nullable();
            $table->integer('total_breaks')->unsigned()->default(0);
            $table->text('notes')->nullable();
            $table->string('last_user_activity', 50)->nullable();
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
        Schema::dropIfExists('timelog_breaks');
    }
}
