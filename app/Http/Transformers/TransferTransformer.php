<?php
namespace App\Http\Transformers;

use App\Models\Transfer;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class TransferTransformer extends TransformerAbstract
{
    protected array $defaultIncludes = ['files'];

    public function transform(Transfer $transfer) : array
    {
        return [
            'id'         => $transfer->id,
            'expires_at' => $transfer->expires_at->timestamp ?? null,
        ];
    }

    public function includeFiles(Transfer $transfer) : Collection
    {
        return $this->collection($transfer->files, new FileTransformer);
    }
}
