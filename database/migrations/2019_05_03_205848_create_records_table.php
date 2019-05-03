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
                $table->integer("device_id")->unsigned();
                $table->integer("product_id")->unsigned();
                $table->integer("location_id")->unsigned();
                $table->timestamps();
                $table->integer("samples");
                $table->integer("delay_time");
                $table->integer("intervals");
                $table->string('slr', 100);
                $table->json('limits');
                $table->json('errors');
                $table->json('alarms');
                $table->text('comments');
                $table->string('status', 100);
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
