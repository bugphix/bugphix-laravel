<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugphixStackTrace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugphix_stack_trace', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('stack_trace_event_id');
            $table->mediumText('stack_trace_error_file')->nullable();
            $table->integer('stack_trace_error_line')->default(0);
            $table->integer('stack_trace_start_line')->default(1);
            $table->longText('stack_trace_full_log')->nullable();
            $table->longText('stack_trace_data')->nullable();

            $table->foreign('stack_trace_event_id')
                ->references('id')
                ->on('bugphix_events')
                ->onDelete('cascade');

            $table->index([
                'stack_trace_event_id'
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
        Schema::dropIfExists('bugphix_stack_trace');
    }
}
