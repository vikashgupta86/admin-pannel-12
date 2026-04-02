<?php

namespace Modules\RRDR\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\RRDR\Models\RRDR;

class RRDRDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * RRDRS Seed
         * ------------------
         */

        // DB::table('rrdrs')->truncate();
        // echo "Truncate: rrdrs \n";

        RRDR::factory()->count(20)->create();
        $rows = RRDR::all();
        echo " Insert: rrdrs \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
