<?php

use Illuminate\Database\Seeder;

class AppStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('app_statuses')->truncate();

        factory(App\Models\AppStatus::class)->states('submitted')->create();
        factory(App\Models\AppStatus::class)->states('approved')->create();
        factory(App\Models\AppStatus::class)->states('denied')->create();
        factory(App\Models\AppStatus::class)->states('deferred')->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
