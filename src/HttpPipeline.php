<?php

namespace Invoke\Http;

use Invoke\Invoke;
use Invoke\Pipeline;
use Invoke\Http\Pipes\BuildResponse;
use Invoke\Http\Pipes\EmitResponse;
use Invoke\Http\Pipes\HandleRequest;
use Invoke\Http\Pipes\ParseRequest;
use Invoke\Http\Pipes\ResultToStream;
use Invoke\Http\Pipes\TransformResult;

class HttpPipeline extends Pipeline
{
    public array $pipes = [
        ParseRequest::class,
        HandleRequest::class,

        Invoke::class,

        TransformResult::class,
        ResultToStream::class,
        BuildResponse::class,
        EmitResponse::class,
    ];
}