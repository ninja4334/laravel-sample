<?php

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('pages')->truncate();

        $data = [
            [
                'slug'      => 'api',
                'title'     => 'API',
                'is_active' => true,
                'is_system' => true
            ],
            [
                'slug'      => 'terms-of-conditions',
                'title'     => 'Terms of conditions',
                'is_active' => true,
                'is_system' => true
            ],
            [
                'slug'      => 'privacy-policy',
                'title'     => 'Privacy policy',
                'is_active' => true,
                'is_system' => true
            ]
        ];

        foreach ($data as $item) {
            factory(App\Models\Page::class)->create($item);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
