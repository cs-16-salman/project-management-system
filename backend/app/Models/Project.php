<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToOrganization;

class Project extends Model
{
    use BelongsToOrganization;

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role_id');
    }
}
