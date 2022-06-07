<?php
namespace App\Http\Transformers;

use App\Models\File;
use League\Fractal\TransformerAbstract;

class FileTransformer extends TransformerAbstract
{
    public function transform(File $file) : array
    {
        return [
            'id'   => $file->id,
            'url'  => $file->url(),
            'name' => $file->name,
        ];
    }
}
