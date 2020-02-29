<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugphixClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugphix_clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_method')->default('GET');
            $table->mediumText('client_url')->nullable();
            $table->string('client_browser');
            $table->string('client_browser_version')->nullable();
            $table->string('client_os');
            $table->ipAddress('client_ip')->nullable();
            $table->longText('client_header')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bugphix_clients');
    }
}
