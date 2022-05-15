<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PatchTransferRequest extends FormRequest
{
    public function authorize() : bool
    {
        return Auth::check();
    }

    public function rules() : array
    {
        return [
            'hours' => 'numeric|min:0|nullable',
            'code'  => 'string',
        ];
    }

    public function wantsChangeCode() : bool
    {
        return $this->has('code');
    }

    public function wantsChangeTime() : bool
    {
        return $this->has('hours');
    }

    public function newExpirationTime() : ?Carbon
    {
        if (empty($this->input('hours'))) {
            return null;
        }

        return Carbon::now()->addHours($this->input('hours'));
    }
}
