<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('records')) {
            Schema::create('records', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer("device_id")->unsigned()->nullable();
                $table->integer("product_id")->unsigned();
                $table->integer("location_id")->unsigned()->nullable();
                $table->timestamps();
                $table->integer("samples");
                $table->integer("delay_time");
                $table->integer("intervals");
                $table->string('slr', 100);
                $table->longText('limits')->nullable();
                $table->longText('errors')->nullable();
                $table->longText('alarms')->nullable();
                $table->text('comments')->nullable();
                $table->boolean('status')->default(true);
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
        Schema::dropIfExists('records');
    }
}
