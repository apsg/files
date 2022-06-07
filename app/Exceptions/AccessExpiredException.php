<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class AccessExpiredException extends Exception
{
    protected $message = 'Brak dostępu';
    protected $code = Response::HTTP_GONE;
}
