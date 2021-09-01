<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user_management_access',
            'permission_create',
            'permission_edit',
            'permission_show',
            'permission_delete',
            'permission_access',
            'role_create',
            'role_edit',
            'role_show',
            'role_delete',
            'role_access',
            'client_create',
            'client_edit',
            'client_show',
            'client_delete',
            'client_access',
            'developer_create',
            'developer_edit',
            'developer_show',
            'developer_delete',
            'developer_access',
            'project_create',
            'project_edit',
            'project_show',
            'project_delete',
            'project_access',
            'task_create',
            'task_edit',
            'task_show',
            'task_delete',
            'task_access'
        ];

        foreach ($permissions as $permision) {
            Permission::create([
                'name' => $permision
            ]);
        }

        //gets all permissions via Gate::before rule; see AuthServiceProvider

        Role::create(['name' => 'admin']);

        $client = Role::create(['name' => 'client']);
        $developer = Role::create(['name' => 'developer']);

        $clientPermissions = [
            'project_edit',
            'project_show',
            'project_access',
            'task_create',
            'task_edit',
            'task_show',
            'task_delete',
            'task_access'
        ];

        foreach ($clientPermissions as $clientPermission) {
            $client->givePermissionTo($clientPermission);
        }

        $developerPermissions = [
            'task_edit',
            'task_show',
            'task_access'
        ];

        foreach ($developerPermissions as $developerPermission) {
            $developer->givePermissionTo($developerPermission);
        }
    }
}
