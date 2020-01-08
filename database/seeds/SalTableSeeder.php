<?php

use Illuminate\Database\Seeder;
use App\SalData;

class SalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salData = new SalData(); $salData->temperature = 0; $salData->sl = 8; $salData->save();
        $salData = new SalData(); $salData->temperature = 1; $salData->sl = 6.5; $salData->save();
        $salData = new SalData(); $salData->temperature = 2; $salData->sl = 5; $salData->save();
        $salData = new SalData(); $salData->temperature = 3; $salData->sl = 4; $salData->save();
        $salData = new SalData(); $salData->temperature = 4; $salData->sl = 3.5; $salData->save();
        $salData = new SalData(); $salData->temperature = 5; $salData->sl = 3.35; $salData->save();
        $salData = new SalData(); $salData->temperature = 6; $salData->sl = 3.15; $salData->save();
        $salData = new SalData(); $salData->temperature = 7; $salData->sl = 3; $salData->save();
        $salData = new SalData(); $salData->temperature = 8; $salData->sl = 2.7; $salData->save();
        $salData = new SalData(); $salData->temperature = 9; $salData->sl = 2.35; $salData->save();
        $salData = new SalData(); $salData->temperature = 10; $salData->sl = 2; $salData->save();
        $salData = new SalData(); $salData->temperature = 11; $salData->sl = 1.75; $salData->save();
        $salData = new SalData(); $salData->temperature = 12; $salData->sl = 1.5; $salData->save();
        $salData = new SalData(); $salData->temperature = 13; $salData->sl = 1.4; $salData->save();
        $salData = new SalData(); $salData->temperature = 14; $salData->sl = 1.3; $salData->save();
        $salData = new SalData(); $salData->temperature = 15; $salData->sl = 1.2; $salData->save();
        $salData = new SalData(); $salData->temperature = 16; $salData->sl = 1.1; $salData->save();
        $salData = new SalData(); $salData->temperature = 17; $salData->sl = 1; $salData->save();
        $salData = new SalData(); $salData->temperature = 18; $salData->sl = 0.92; $salData->save();
        $salData = new SalData(); $salData->temperature = 19; $salData->sl = 0.89; $salData->save();
        $salData = new SalData(); $salData->temperature = 20; $salData->sl = 0.85; $salData->save();
        $salData = new SalData(); $salData->temperature = 21; $salData->sl = 0.83; $salData->save();
        $salData = new SalData(); $salData->temperature = 22; $salData->sl = 0.8; $salData->save();
        $salData = new SalData(); $salData->temperature = 23; $salData->sl = 0.78; $salData->save();
        $salData = new SalData(); $salData->temperature = 24; $salData->sl = 0.75; $salData->save();
        $salData = new SalData(); $salData->temperature = 25; $salData->sl = 0.73; $salData->save();
        $salData = new SalData(); $salData->temperature = 26; $salData->sl = 0.71; $salData->save();
        $salData = new SalData(); $salData->temperature = 27; $salData->sl = 0.69; $salData->save();
        $salData = new SalData(); $salData->temperature = 28; $salData->sl = 0.67; $salData->save();
        $salData = new SalData(); $salData->temperature = 29; $salData->sl = 0.62; $salData->save();
        $salData = new SalData(); $salData->temperature = 30; $salData->sl = 0.6; $salData->save();
    }
}
