<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToOrganization
{
    protected static function bootBelongsToOrganization()
    {
        // Auto-fill organization_id when creating
        static::creating(function ($model) {
            if (app()->has('currentOrganization')) {
                $model->organization_id = app('currentOrganization')->id;
            }
        });

        // Automatically scope queries
        static::addGlobalScope('organization', function (Builder $builder) {
            if (app()->has('currentOrganization')) {
                $builder->where('organization_id', app('currentOrganization')->id);
            }
        });
    }
}
