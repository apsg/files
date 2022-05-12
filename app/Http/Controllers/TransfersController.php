<?php
namespace App\Http\Controllers;

use App\Models\Transfer;
use App\Repositories\TransfersRepository;
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
            'transfer' => $transfer,
        ]);
    }
}
