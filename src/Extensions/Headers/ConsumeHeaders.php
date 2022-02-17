<?php

namespace Invoke\Http\Extensions\Headers;

use Attribute;
use Invoke\Container;
use Invoke\Extensions\MethodExtension;
use Invoke\Http\Exceptions\RequiredHeaderNotProvidedException;
use Invoke\Method;
use Invoke\Support\Description\Headers\ConsumeHeadersInterface;
use Invoke\Support\Description\Headers\HeaderDescriptionInterface;
use Invoke\Types\AnyType;
use Psr\Http\Message\ServerRequestInterface;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_FUNCTION)]
class ConsumeHeaders extends MethodExtension implements ConsumeHeadersInterface
{
    /**
     * @var HeaderDescriptionInterface[] $headers
     */
    public array $headers;

    /**
     * @param string|HeaderDescriptionInterface|HeaderDescriptionInterface[] $headers
     */
    public function __construct(array|string|HeaderDescriptionInterface $headers)
    {
        if (is_string($headers)) {
            $headers = [new HeaderDescription($headers, AnyType::getInstance(), true)];
        }

        if ($headers instanceof HeaderDescriptionInterface) {
            $headers = [$headers];
        }

        $this->headers = $headers;
    }

    public function beforeValidation(Method $method): void
    {
        $request = Container::get(ServerRequestInterface::class);

        foreach ($this->headers as $headerDescription) {
            $headerName = $headerDescription->getName();

            if (!$headerDescription->isOptional() && !$request->hasHeader($headerName)) {
                throw new RequiredHeaderNotProvidedException($headerName);
            }

            $header = $request->getHeader($headerName);

            // todo: validate header type
        }
    }

    /**
     * @inheritDoc
     */
    public function getConsumedHeaders(): array
    {
        return $this->headers;
    }
}