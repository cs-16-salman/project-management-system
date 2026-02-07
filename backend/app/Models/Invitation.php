<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToOrganization;

class Invitation extends Model
{
    use BelongsToOrganization;
}
