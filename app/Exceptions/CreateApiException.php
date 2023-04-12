<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CreateApiException extends Exception
{
    public function render($request)
    {
        return new JsonResponse([
            'message' => $this->getMessage(),
            'success' => false
        ], $this->getCode());
    }
}
