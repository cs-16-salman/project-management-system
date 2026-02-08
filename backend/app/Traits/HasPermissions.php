<?php

namespace App\Traits;

trait HasPermissions
{
    public function hasPermission($permission)
    {
        $currentOrg = app('currentOrganization');

        $membership = $this->organizations()
            ->where('organizations.id', $currentOrg->id)
            ->first();

        if (!$membership || !$membership->pivot->role) {
            return false;
        }

        return $membership->pivot->role
            ->permissions()
            ->where('name', $permission)
            ->exists();
    }
}
