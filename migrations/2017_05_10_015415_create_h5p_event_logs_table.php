<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateH5pEventLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h5p_event_logs', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('type', 63);
            $table->string('sub_type', 63);
            $table->integer('content_id')->unsigned();
            $table->string('content_title', 255);
            $table->string('library_name', 127);
            $table->string('library_version', 31);
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
        Schema::drop('h5p_event_logs');
    }
}
