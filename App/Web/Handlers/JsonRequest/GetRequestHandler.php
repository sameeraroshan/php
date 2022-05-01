<?php


namespace Serato\Web\Handlers\JsonRequest;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Serato\Web\Handlers\JsonRequestHandler;

class GetRequestHandler extends JsonRequestHandler
{
    public function httpMethod(): string
    {
        return "GET";
    }

    /** GET request handler.GET requests are used with query params. therefore request body is ignored.
     * query params are sent back to the client
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function execute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        //$request body is ignored since this is get request
        $queryParams = $request->getQueryParams();
        return $this->jsonResponse($response, $queryParams);
    }
}