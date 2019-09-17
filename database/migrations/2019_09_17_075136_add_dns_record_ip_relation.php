<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDnsRecordIpRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dns_records', function (Blueprint $table) {
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
        Schema::table('dns_records', function (Blueprint $table) {
            $table->dropForeign('dns_records_ip_id_foreign');
            $table->dropColumn('ip_id');
        });
    }
}
