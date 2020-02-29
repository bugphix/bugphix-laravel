<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugphixEventServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugphix_event_servers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id')->unique();
            $table->unsignedBigInteger('server_id')->nullable();

            $table->foreign('event_id')
                ->references('id')
                ->on('bugphix_events')
                ->onDelete('cascade');

            $table->foreign('server_id')
                ->references('id')
                ->on('bugphix_servers')
                ->onDelete('cascade');

            $table->index([
                'event_id',
                'server_id',
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
        Schema::dropIfExists('bugphix_event_servers');
    }
}
