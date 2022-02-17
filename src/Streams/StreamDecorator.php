<?php

namespace Invoke\Http\Streams;

use Psr\Http\Message\StreamInterface;

interface StreamDecorator
{
    public function getStream(): StreamInterface;
}
