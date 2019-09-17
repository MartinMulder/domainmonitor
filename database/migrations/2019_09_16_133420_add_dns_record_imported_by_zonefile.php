<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDnsRecordImportedByZonefile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dns_records', function (Blueprint $table) {
            $table->boolean('imported_by_zonefile')->default(false);
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
            $table->dropColumn('imported_by_zonefile');
        });
    }
}
