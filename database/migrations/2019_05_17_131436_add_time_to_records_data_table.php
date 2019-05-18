<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeToRecordsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('records_data', function (Blueprint $table) {
            $table->time('time')->nullable();
            $table->date('date')->nullable();
            $table->integer('records_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('records_data', function (Blueprint $table) {
            $table->time('time')->nullable();
            $table->date('date')->nullable();
            $table->integer('records_id')->unsigned();
        });
    }
}
