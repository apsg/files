<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int                    id
 * @property string                 name
 * @property string                 hash
 * @property string                 code
 * @property Carbon|null            expires_at
 * @property Carbon                 created_at
 * @property Carbon                 updated_at
 *
 * @property-read Collection|File[] files
 */
class Transfer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function files() : HasMany
    {
        return $this->hasMany(File::class);
    }
}
