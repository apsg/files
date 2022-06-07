<?php
namespace App\Http\Requests;

use App\Models\Transfer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class DownloadFileRequest extends FormRequest
{
    public function authorize() : bool
    {
        /** @var Transfer $transfer */
        $transfer = $this->route('transfer');

        if ($transfer->isExpired()) {
            return false;
        }

        if (!Hash::check($this->input('code'), $transfer->code)) {
            return false;
        }

        return true;
    }

    public function rules() : array
    {
        return [
            'code' => 'required|string',
        ];
    }
}
