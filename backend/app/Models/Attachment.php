<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToOrganization;

/**
 * @property int $id
 * @property string $organization_id
 * @property string $task_id
 * @property string $uploaded_by
 * @property string $file_path
 * @property string $file_name
 * @property int $file_size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Attachment whereUploadedBy($value)
 * @mixin \Eloquent
 */
class Attachment extends Model
{
    use BelongsToOrganization;
}
