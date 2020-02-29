<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugphixIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugphix_issues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('issue_project_id');
            $table->mediumText('issue_error_exception');
            $table->mediumText('issue_error_message');
            $table->enum('issue_status', ['unresolved', 'resolved', 'ignored'])->default('unresolved');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('issue_project_id')
                ->references('project_id')
                ->on('bugphix_projects')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bugphix_issues');
    }
}
