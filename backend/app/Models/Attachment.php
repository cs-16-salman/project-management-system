<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToOrganization;

class Attachment extends Model
{
    use BelongsToOrganization;
}
