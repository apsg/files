<?php
namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Models\File;
use App\Models\Transfer;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilesController extends Controller
{
    public function store(Transfer $transfer, FileUploadRequest $request)
    {
        $uploadedFile = $request->file('file');
        $filename = Str::random() . '.enc';
        $result = Storage::disk('s3')->put($filename, Crypt::encrypt($uploadedFile->getContent()));

        if ($result === true) {
            /** @var File $file */
            $file = $transfer->files()->create([
                'location' => $filename,
                'name'     => $request->file('file')->getClientOriginalName(),
            ]);
        }
        unlink($request->file('file')->getRealPath());

        return response()->json([
            'id' => $file->id,
        ]);
    }

    public function destroy(File $file)
    {
        $file->delete();

        return response()->json('ok');
    }
}
