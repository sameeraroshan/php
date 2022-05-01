<?php


namespace Serato\Web\Handlers\JsonRequest;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Serato\Web\Handlers\JsonRequestHandler;

class PostRequestHandler extends JsonRequestHandler
{

    public function httpMethod(): string
    {
        return "POST";
    }

    /**
     * POST request handler. POST content are sent though request body.Therefore request body is parsed based on its
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function execute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($this->isValidJson((string)$request->getBody())) {
            //sending back requested json.
            $response = $this->jsonResponse($response, (string)$request->getBody());
        } else {
            $response = $response->withStatus('400', 'Bad JSON Content');
        }
        return $response;
    }
}