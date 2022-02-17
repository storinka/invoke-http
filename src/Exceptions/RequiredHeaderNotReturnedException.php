<?php

namespace Invoke\Http\Exceptions;

use Invoke\Exceptions\PipeException;

class RequiredHeaderNotReturnedException extends PipeException
{
    public function __construct(string $header)
    {
        parent::__construct("Required header \"$header\" not returned.", 500);
    }

    public function getHttpCode(): int
    {
        return 500;
    }
}