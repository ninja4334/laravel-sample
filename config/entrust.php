<?php

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Entrust Role Model
    |--------------------------------------------------------------------------
    |
    | This is the Role model used by Entrust to create correct relations.  Update
    | the role if it is in a different namespace.
    |
    */
    'role'                  => 'App\Models\Role',

    /*
    |--------------------------------------------------------------------------
    | Entrust Roles Table
    |--------------------------------------------------------------------------
    |
    | This is the roles table used by Entrust to save roles to the database.
    |
    */
    'roles_table'           => 'roles',

    /*
    |--------------------------------------------------------------------------
    | Entrust Permission Model
    |--------------------------------------------------------------------------
    |
    | This is the Permission model used by Entrust to create correct relations.
    | Update the permission if it is in a different namespace.
    |
    */
    'permission'            => 'App\Models\Permission',

    /*
    |--------------------------------------------------------------------------
    | Entrust Permissions Table
    |--------------------------------------------------------------------------
    |
    | This is the permissions table used by Entrust to save permissions to the
    | database.
    |
    */
    'permissions_table'     => 'permissions',

    /*
    |--------------------------------------------------------------------------
    | Entrust permission_role Table
    |--------------------------------------------------------------------------
    |
    | This is the permission_role table used by Entrust to save relationship
    | between permissions and roles to the database.
    |
    */
    'permission_role_table' => 'x_permission_role',

    /*
    |--------------------------------------------------------------------------
    | Entrust role_user Table
    |--------------------------------------------------------------------------
    |
    | This is the role_user table used by Entrust to save assigned roles to the
    | database.
    |
    */
    'role_user_table'       => 'x_role_user',

    /*
    |--------------------------------------------------------------------------
    | User Foreign key on Entrust's role_user Table (Pivot)
    |--------------------------------------------------------------------------
    */
    'user_foreign_key'      => 'user_id',

    /*
    |--------------------------------------------------------------------------
    | Role Foreign key on Entrust's role_user Table (Pivot)
    |--------------------------------------------------------------------------
    */
    'role_foreign_key'      => 'role_id',

    /*
    |--------------------------------------------------------------------------
    | Default roles
    |--------------------------------------------------------------------------
    */
    'role_list'             => [
        ['name' => 'super_admin', 'display_name' => 'Super admin', 'is_system' => true],
        ['name' => 'system', 'display_name' => 'System', 'is_system' => true],
        ['name' => 'admin', 'display_name' => 'Admin', 'is_system' => true],
        ['name' => 'reviewer', 'display_name' => 'Reviewer', 'is_system' => true],
        ['name' => 'member', 'display_name' => 'Member', 'is_system' => true],
        ['name' => 'staff', 'display_name' => 'Staff', 'is_system' => false]
    ],

    /*
    |--------------------------------------------------------------------------
    | Default permissions
    |--------------------------------------------------------------------------
    */
    'permission_list'       => [

        // Settings
        ['name' => 'settings.view', 'display_name' => 'View settings', 'is_system' => true],
        ['name' => 'settings.manage', 'display_name' => 'Manage settings', 'is_system' => true],

        // Pages
        ['name' => 'pages.view', 'display_name' => 'View pages', 'is_system' => true],
        ['name' => 'pages.manage', 'display_name' => 'Manage pages', 'is_system' => true],

        // Users
        ['name' => 'users.view', 'display_name' => 'View users', 'is_system' => true],
        ['name' => 'users.manage', 'display_name' => 'Manage users', 'is_system' => true],

        // Boards
        ['name' => 'boards.view', 'display_name' => 'View boards', 'is_system' => false],
        ['name' => 'boards.manage', 'display_name' => 'Manage boards', 'is_system' => false],
        ['name' => 'boards.fee.view', 'display_name' => 'View boards fee', 'is_system' => true],
        ['name' => 'boards.fee.manage', 'display_name' => 'Manage boards fee', 'is_system' => true],

        // Board users
        ['name' => 'boards.users.view', 'display_name' => 'View board users', 'is_system' => false],
        ['name' => 'boards.users.manage', 'display_name' => 'Manage board users', 'is_system' => false],

        // Board roles
        ['name' => 'boards.roles.view', 'display_name' => 'View board roles', 'is_system' => false],
        ['name' => 'boards.roles.manage', 'display_name' => 'Manage board roles', 'is_system' => false],

        // Board professions
        ['name' => 'boards.professions.view', 'display_name' => 'View board professions', 'is_system' => false],
        ['name' => 'boards.professions.manage', 'display_name' => 'Manage board professions', 'is_system' => false],

        // Board transactions
        ['name' => 'boards.transactions.view', 'display_name' => 'View board transactions', 'is_system' => false],

        // Applications
        ['name' => 'apps.view', 'display_name' => 'View vault', 'is_system' => false],
        ['name' => 'apps.manage', 'display_name' => 'Manage vault', 'is_system' => false],

        // Application types
        ['name' => 'apps.types.view', 'display_name' => 'View app types', 'is_system' => false],
        ['name' => 'apps.types.manage', 'display_name' => 'Manage app types', 'is_system' => false],

        // Application statuses
        ['name' => 'apps.statuses.manage', 'display_name' => 'Manage app statuses', 'is_system' => false],

        // Application notifications
        ['name' => 'apps.notifications.manage', 'display_name' => 'Manage app notifications', 'is_system' => false],

        // Submissions
        ['name' => 'submissions.view', 'display_name' => 'View submissions', 'is_system' => false],
        ['name' => 'submissions.manage', 'display_name' => 'Manage submissions', 'is_system' => false],

        // Submission notes
        ['name' => 'submissions.notes.view', 'display_name' => 'View submission notes', 'is_system' => false],
        ['name' => 'submissions.notes.manage', 'display_name' => 'Manage submission notes', 'is_system' => false],

        // Members
        ['name' => 'members.view', 'display_name' => 'View members', 'is_system' => false],
        ['name' => 'members.manage', 'display_name' => 'Manage members', 'is_system' => false]
    ]

];