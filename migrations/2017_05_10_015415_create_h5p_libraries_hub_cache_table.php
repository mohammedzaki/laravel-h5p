<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateH5pLibrariesHubCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h5p_libraries_hub_cache', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('machine_name', 127);
            $table->integer('major_version')->unsigned();
            $table->integer('minor_version')->unsigned();
            $table->integer('patch_version')->unsigned();
            $table->integer('h5p_major_version')->unsigned()->nullable();
            $table->integer('h5p_minor_version')->unsigned()->nullable();
            $table->string('title', 255);
            $table->text('summary');
            $table->text('description');
            $table->string('icon', 511);
            $table->integer('created_at')->unsigned();
            $table->integer('updated_at')->unsigned();
            $table->integer('is_recommended')->unsigned();
            $table->integer('popularity')->unsigned();
            $table->text('screenshots')->nullable();
            $table->text('license')->nullable();
            $table->string('example', 511);
            $table->string('tutorial', 511)->nullable();
            $table->text('keywords')->nullable();
            $table->text('categories')->nullable();
            $table->string('owner', 511)->nullable();
            $table->index(['machine_name', 'major_version', 'minor_version', 'patch_version'], 'name_version');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('h5p_libraries_hub_cache');
    }
}
