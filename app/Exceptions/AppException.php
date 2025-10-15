<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    protected $statusCode;

    public function __construct($message, $code)
    {
        parent::__construct($message);
        $this->statusCode = $code;
    }

    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
            'code' => $this->statusCode,
        ], $this->statusCode);
    }
}
