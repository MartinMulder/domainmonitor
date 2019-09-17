<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWhoisDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whois_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('domain_id');
            $table->string('domainname');
            $table->string('active');
            $table->string('dnsservers');
            $table->string('owner')->nullable();
            $table->string('registrar');
            $table->datetime('creationDate')->nullable();
            $table->datetime('expirationDate')->nullable();
            $table->string('whoisserver')->nullable();
            $table->text('rawData');
            $table->foreign('domain_id')->references('id')->on('domains')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('whois_data');
    }
}
