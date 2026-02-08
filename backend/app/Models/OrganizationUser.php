<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationUser extends Model
{
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
