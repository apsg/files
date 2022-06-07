<?php
namespace App\Http\Controllers;

use App\Http\Requests\DownloadFileRequest;
use App\Http\Requests\VerifyCodeRequest;
use App\Http\Transformers\TransferTransformer;
use App\Models\File;
use App\Models\Transfer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Spatie\Fractalistic\ArraySerializer;

class TransfersController extends Controller
{
    public function show(Transfer $transfer)
    {
        return Inertia::render('Transfer', [
            'transfer' => fractal($transfer, new TransferTransformer(), new ArraySerializer())->toArray(),
        ]);
    }

    public function verify(Transfer $transfer, VerifyCodeRequest $request)
    {
        $isAuthorized = Hash::check($request->input('code'), $transfer->code);

        return [
            'is_authorized' => $isAuthorized,
        ];
    }

    public function download(Transfer $transfer, File $file, DownloadFileRequest $request)
    {
        $encryptedFile = Storage::get($file->location);

        return response(Crypt::decrypt($encryptedFile), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename=' . $file->name,
        ]);
    }
}
