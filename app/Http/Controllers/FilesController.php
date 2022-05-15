<?php
namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Models\File;
use App\Models\Transfer;
use Brainstud\FileVault\Facades\FileVault;
use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function store(Transfer $transfer, FileUploadRequest $request)
    {
        $filename = $request->file('file')->store('files');
        FileVault::encrypt($filename);

        /** @var File $file */
        $file = $transfer->files()->create([
            'location' => $filename,
            'name'     => $request->file('file')->getClientOriginalName(),
        ]);
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
