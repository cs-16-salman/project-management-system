<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToOrganization;

class Comment extends Model
{
    use BelongsToOrganization;
}
