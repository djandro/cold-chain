<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocationToRecordsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('records_data', function (Blueprint $table) {
            $table->integer("location_id")->unsigned()->nullable()->after('records_id');
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
            $table->integer("location_id");
        });
    }
}
