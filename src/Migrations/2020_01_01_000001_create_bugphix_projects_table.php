<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugphixProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugphix_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_id')->unique();
            $table->string('project_name');
            $table->string('project_description')->nullable();
            $table->string('project_platform')->default('laravel');
            $table->string('project_token');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bugphix_projects');
    }
}
