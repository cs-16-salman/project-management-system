<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait HasPermissions
{
    public function hasPermission($permission)
    {
        if (!app()->has('currentOrganization')) {
            return false;
        }

        $orgId = app('currentOrganization')->id;

        return DB::table('organization_user')
            ->join('role_permission', 'organization_user.role_id', '=', 'role_permission.role_id')
            ->join('permissions', 'role_permission.permission_id', '=', 'permissions.id')
            ->where('organization_user.user_id', $this->id)
            ->where('organization_user.organization_id', $orgId)
            ->where('permissions.name', $permission)
            ->exists();
    }
}
