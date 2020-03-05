<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('u_id', 10)->nullable();
            $table->integer('path_id')->nullable()->unsigned();
            $table->text('name')->nullable();
            $table->string('hash_name', 255)->nullable();
            $table->integer('size')->nullable()->unsigned();
            $table->string('mime_type', 255)->nullable();
            $table->string('ext', 5)->nullable();
            $table->string('_input', 255)->nullable();
            $table->string('version', 5)->nullable();
            $table->integer('parent_id')->nullable()->unsigned();
            $table->integer('user_id')->nullable()->unsigned();
            $table->tinyInteger('is_current')->nullable()->unsigned();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('documents');
    }
}
