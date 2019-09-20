<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZoneFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zone_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('title');
            $table->string('source')->default('bit_portal');
            $table->text('content');
            $table->boolean('imported')->dafault(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zone_files');
    }
}
