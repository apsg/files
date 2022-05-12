<?php
namespace App\Repositories;

use App\Models\Transfer;
use Carbon\Carbon;

class TransfersRepository
{
    public function create() : Transfer
    {
        return Transfer::factory(1)->create([
            'expires_at' => Carbon::now()->addHours(48),
        ])->first();
    }

}
