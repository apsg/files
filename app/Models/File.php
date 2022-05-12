<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int           id
 * @property string        name
 * @property string        location
 * @property int           transfer_id
 * @property Carbon        created_at
 * @property Carbon        updated_at
 *
 * @property-read Transfer transfer
 */
class File extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function transfer() : BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }
}
