<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('records_data')) {
            Schema::create('records_data', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreign('records_id')->references('id')->on('records')->onDelete('cascade');;
                $table->timestamp('timestamp');
                $table->float('temperature', 8, 2);
                $table->float('humidity', 8, 2);
                $table->float('dew_points', 8, 2);
                $table->float('battery_voltage', 8, 2);
                $table->boolean('is_calculated')->defalut(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records_data');
    }
}
