<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateH5pLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h5p_libraries', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->timestamps();
            $table->string('name', 127);
            $table->string('title');
            $table->integer('major_version')->unsigned();
            $table->integer('minor_version')->unsigned();
            $table->integer('patch_version')->unsigned();
            $table->integer('runnable')->unsigned()->index('runnable');
            $table->integer('restricted')->unsigned()->default(0);
            $table->integer('fullscreen')->unsigned();
            $table->string('embed_types', 255);
            $table->text('preloaded_js')->nullable();
            $table->text('preloaded_css')->nullable();
            $table->text('drop_library_css')->nullable();
            $table->text('semantics');
            $table->string('tutorial_url', 1023);
            $table->integer('has_icon')->unsigned()->default(0);
            $table->text('metadata_settings')->nullable();
            $table->text('add_to')->nullable();
            $table->index(['name', 'major_version', 'minor_version', 'patch_version'], 'name_version');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('h5p_libraries');
    }
}
