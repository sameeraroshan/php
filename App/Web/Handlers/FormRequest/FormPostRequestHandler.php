<?php


namespace Serato\Web\Handlers\FormRequest;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Serato\Web\Handlers\FormRequestHandler;

class FormPostRequestHandler extends FormRequestHandler
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
        $message = "<h1>Html Response</h1></br><h2> Html response</h2>";
        $response = $this->htmlResponse($response, $message);
        return $response;
    }
}