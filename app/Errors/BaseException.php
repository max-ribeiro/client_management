<?php

namespace App\Errors;

class BaseException extends \Exception
{
    protected $exceptionMessage = '';
    protected $code = 500;

    public function __construct(string $exceptionMessage, int $code = 500)
    {
        $this->exceptionMessage = $exceptionMessage;
        $this->code = $code;
        parent::__construct($exceptionMessage, $code);
    }
}
