<?php

use Illuminate\Database\Seeder;

class AppTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('app_types')->truncate();

        factory(App\Models\AppType::class, 5)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
