<?php

namespace Modules\MenuManage\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\MenuManage\Models\MenuManage;

class MenuManageDatabaseSeeder extends Seeder
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
         * MenuManages Seed
         * ------------------
         */

        // DB::table('menumanages')->truncate();
        // echo "Truncate: menumanages \n";

        MenuManage::factory()->count(20)->create();
        $rows = MenuManage::all();
        echo " Insert: menumanages \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
