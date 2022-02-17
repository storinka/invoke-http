<?php

namespace Invoke\Http\Data;

use Invoke\Attributes\Parameter;
use Invoke\Data;

class FailedResponseData extends Data
{
    #[Parameter]
    public int $code;

    #[Parameter]
    public string $error;

    #[Parameter]
    public string $message;
}
