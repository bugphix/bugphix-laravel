<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugphixEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugphix_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_issue_id');
            $table->string('event_environment')->nullable();
            $table->timestamps();

            $table->foreign('event_issue_id')
                ->references('id')
                ->on('bugphix_issues')
                ->onDelete('cascade');

            $table->index([
                'event_issue_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bugphix_events');
    }
}
