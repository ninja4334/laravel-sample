<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('x_permission_role')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();

        // Seed the default roles
        foreach (config('entrust.role_list') as $role) {
            factory(App\Models\Role::class)->create($role);
        }

        // Seed the default permissions
        foreach (config('entrust.permission_list') as $permission) {
            factory(App\Models\Permission::class)->create($permission);
        }

        // Attach the permissions to roles
        factory(App\Models\Permission::class)->make()->each(function ($permission) {
            switch ($permission->name) {

                case 'settings.manage':

                case 'pages.manage':

                case 'users.manage':
                    $permission->roles()->save(App\Models\Role::where('name', 'super_admin')->first());
                    break;

                case 'boards.view':
                case 'boards.manage':

                case 'boards.users.view':
                case 'boards.users.manage':

                case 'boards.roles.view':
                case 'boards.roles.manage':

                case 'boards.professions.view':
                case 'boards.professions.manage':

                case 'boards.transactions.view':

                case 'apps.view':
                case 'apps.manage':

                case 'apps.types.view':
                case 'apps.types.manage':

                case 'apps.statuses.manage':

                case 'apps.notifications.manage':

                case 'submissions.view':
                case 'submissions.manage':

                case 'submissions.notes.view':
                case 'submissions.notes.manage':

                case 'members.view':
                case 'members.manage':
                    $permission->roles()->save(App\Models\Role::where('name', 'admin')->first());
                    break;
            }
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
