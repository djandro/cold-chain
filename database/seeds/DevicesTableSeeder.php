<?php

use Illuminate\Database\Seeder;
use App\Device;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $device = new Device();
        $device->name = "TIDA";
        $device->save();

        $device = new Device();
        $device->name = "RHT10";
        $device->save();

        $device = new Device();
        $device->name = "Generated";
        $device->save();
    }
}
