<?php

namespace Invoke\Http\Streams;

use Psr\Http\Message\StreamInterface;

class TextStreamDecorator
{
    public function __construct(public readonly StreamInterface $stream)
    {
    }

    /**
     * @return StreamInterface
     */
    public function getStream(): StreamInterface
    {
        return $this->stream;
    }
}
