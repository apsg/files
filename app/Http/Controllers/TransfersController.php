<?php
namespace App\Http\Controllers;

use App\Http\Requests\PatchTransferRequest;
use App\Models\Transfer;
use App\Repositories\TransfersRepository;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class TransfersController extends Controller
{
    public function store(TransfersRepository $repository)
    {
        $transfer = $repository->create();

        return redirect(route('transfers.edit', $transfer));
    }

    public function edit(Transfer $transfer)
    {
        return Inertia::render('EditTransfer')->with([
            'transfer' => $transfer->append('hours'),
            'token'    => csrf_token(),
        ]);
    }

    public function update(Transfer $transfer, PatchTransferRequest $request)
    {
        if ($request->wantsChangeCode()) {
            $transfer->update([
                'code' => Hash::make($request->input('code')),
            ]);
        }

        if ($request->wantsChangeTime()) {
            $transfer->update([
                'expires_at' => $request->newExpirationTime(),
            ]);
        }

        return $transfer;
    }

    public function getFiles(Transfer $transfer)
    {
        return $transfer->files;
    }
}
