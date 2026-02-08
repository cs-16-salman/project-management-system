<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage_users',
            'manage_projects',
            'create_task',
            'update_task',
            'delete_task',
            'assign_task',
            'comment_task',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'id' => Str::uuid(),
                'name' => $perm,
                'module' => 'core',
            ]);
        }

        $orgAdmin = Role::firstOrCreate([
            'id' => Str::uuid(),
            'name' => 'Organization Admin',
            'scope' => 'organization',
        ]);

        $member = Role::firstOrCreate([
            'name' => 'Member',
            'scope' => 'organization',
        ]);

        // Admin gets all permissions
        $orgAdmin->permissions()->sync(Permission::pluck('id'));

        // Member gets limited permissions
        $member->permissions()->sync(
            Permission::whereIn('name', ['create_task', 'update_task'])->pluck('id')
        );
    }
}
