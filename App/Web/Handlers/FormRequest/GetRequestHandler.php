<?php


namespace Serato\Web\Handlers\FormRequest;;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Serato\Web\Handlers\FormRequestHandler;

class GetRequestHandler extends FormRequestHandler
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
    {   //$request body is ignored since this is get request
        $queryParams = $request->getQueryParams();
        $message = "<h1>Html Response</h1></br><h2> Html response for GET request" . json_encode($queryParams) . "</h2>";
        return $this->htmlResponse($response, $message);
    }

}