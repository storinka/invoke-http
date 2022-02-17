<?php

namespace Invoke\Http\Pipes;

use Invoke\Pipe;
use Invoke\Http\Data\SuccessResponseData;

class TransformResult implements Pipe
{
    public function pass(mixed $value): mixed
    {
        return SuccessResponseData::from([
            "result" => $value,
        ]);
    }
}
