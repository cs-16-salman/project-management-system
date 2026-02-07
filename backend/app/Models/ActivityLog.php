<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToOrganization;

class ActivityLog extends Model
{
    use BelongsToOrganization;
}
