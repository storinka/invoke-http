<?php

namespace Invoke\Http\Pipes;

use Invoke\Container;
use Invoke\Exceptions\NotFoundException;
use Invoke\Invoke;
use Invoke\Pipe;
use Invoke\Stop;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use function Invoke\Utils\vdd;

/**
 * HTTP request handler pipe.
 */
class HandleRequest implements Pipe
{
    /**
     * @param ServerRequestInterface $request
     * @return mixed
     */
    public function pass(mixed $request): mixed
    {
        if ($request instanceof Stop) {
            return $request;
        }

        if (!($request instanceof ServerRequestInterface)) {
            throw new RuntimeException("The value for HandleRequest pipe must be a ServerRequestInterface.");
        }

        $name = $this->extractMethodName($request);
        $params = $this->extractMethodParameters($request);

        return [
            "name" => $name,
            "params" => $params,
        ];
    }

    protected function extractMethodName(ServerRequestInterface $request): string
    {
        $invoke = Container::get(Invoke::class);

        $pathPrefix = $invoke->getConfig("server.pathPrefix");
        $pathPrefix = trim($pathPrefix, "/");

        $path = $request->getUri()->getPath();
        $path = trim($path, "/");

        if (!str_starts_with($path, $pathPrefix)) {
            throw new NotFoundException();
        }

        if ($path == $pathPrefix) {
            throw new NotFoundException();
        }

        $rest = mb_substr($path, mb_strlen($pathPrefix));

        return trim($rest, "/");
    }

    protected function extractMethodParameters(ServerRequestInterface $request): array
    {
        if ($request->getHeaderLine("Content-Type") === "application/json") {
            return json_decode($request->getBody(), true);
        }

        return array_merge(
            $request->getUploadedFiles(),
            $request->getParsedBody() ?? [],
            $request->getQueryParams(),
        );
    }
}
