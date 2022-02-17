<?php

namespace Invoke\Http;

use Invoke\Http\Pipes\BuildResponse;
use Invoke\Http\Pipes\EmitResponse;
use Invoke\Http\Pipes\ResultToStream;
use Invoke\Http\Pipes\TransformException;
use Invoke\Pipeline;

class HttpErrorPipeline extends Pipeline
{
    public array $pipes = [
        TransformException::class,
        ResultToStream::class,
        BuildResponse::class,
        EmitResponse::class,
    ];
}