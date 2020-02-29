<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugphixEventClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugphix_event_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id')->unique();
            $table->unsignedBigInteger('client_id')->nullable();

            $table->foreign('event_id')
                ->references('id')
                ->on('bugphix_events')
                ->onDelete('cascade');

            $table->foreign('client_id')
                ->references('id')
                ->on('bugphix_clients')
                ->onDelete('cascade');

            $table->index([
                'event_id',
                'client_id',
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
        Schema::dropIfExists('bugphix_event_clients');
    }
}
