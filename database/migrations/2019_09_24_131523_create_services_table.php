<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedInteger('port');
            $table->string('protocol');
            $table->string('state');
            $table->string('service_name');
            $table->string('product')->nullable();
            $table->string('version')->nullable();
            $table->unsignedBigInteger('ip_id')->nullable();
            $table->foreign('ip_id')->references('id')->on('ips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
