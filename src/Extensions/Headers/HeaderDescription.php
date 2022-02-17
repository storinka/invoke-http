<?php

namespace Invoke\Http\Extensions\Headers;

use Invoke\Support\Description\Headers\HeaderDescriptionInterface;
use Invoke\Type;

class HeaderDescription implements HeaderDescriptionInterface
{
    public function __construct(protected string  $name,
                                protected Type    $type,
                                protected bool    $optional = true,
                                protected ?string $summary = null,
                                protected ?string $description = null)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function isOptional(): bool
    {
        return $this->optional;
    }
}