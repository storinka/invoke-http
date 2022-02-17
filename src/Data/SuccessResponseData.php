<?php

namespace Invoke\Http\Data;

use Invoke\Data;
use Invoke\Support\WithReadonlyParams;

class SuccessResponseData extends Data
{
    use WithReadonlyParams;

    public readonly mixed $result;
}
