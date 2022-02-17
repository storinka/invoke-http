<?php

namespace Invoke\Http\Extensions\Headers;

use Attribute;
use Invoke\Container;
use Invoke\Extensions\MethodExtension;
use Invoke\Http\Exceptions\RequiredHeaderNotReturnedException;
use Invoke\Method;
use Invoke\Support\Description\Headers\HeaderDescriptionInterface;
use Invoke\Support\Description\Headers\ProvideHeadersInterface;
use Invoke\Types\AnyType;
use Psr\Http\Message\ResponseInterface;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_FUNCTION)]
class ProvideHeaders extends MethodExtension implements ProvideHeadersInterface
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

    public function afterHandle(Method $method, mixed $result): void
    {
        $response = Container::get(ResponseInterface::class);

        foreach ($this->headers as $headerDescription) {
            $headerName = $headerDescription->getName();

            if (!$headerDescription->isOptional() && !$response->hasHeader($headerName)) {
                throw new RequiredHeaderNotReturnedException($headerName);
            }

            $header = $response->getHeader($headerName);

            // todo: validate header type
        }
    }

    /**
     * @inheritDoc
     */
    public function getProvidedHeaders(): array
    {
        return $this->headers;
    }
}