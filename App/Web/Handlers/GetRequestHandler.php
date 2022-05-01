<?php


namespace Serato\Web\Handlers;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetRequestHandler extends AbstractRequestHandler
{
    public function httpMethod(): string
    {
        return "GET";
    }

    /** GET request handler.GET requests are used with query params. therefore request body is ignored.
     * query params are sent back to the client
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $contentType
     * @return ResponseInterface
     */
    public function execute(ServerRequestInterface $request, ResponseInterface $response, $contentType): ResponseInterface
    {
        //$request body is ignored since this is get request
        $queryParams = $request->getQueryParams();
        switch ($contentType) {
            case ContentTypes::JSON;
                //converting query params to json object and sent it back.
                return $this->jsonResponse($response, $queryParams);
            case ContentTypes::HTML_FORM;
                $message = "<h1>Html Response</h1></br><h2> Html response for GET request" . json_encode($queryParams) . "</h2>";
                return $this->htmlResponse($response, $message);
            default:
                return $response->withStatus('405', 'Content type not supported!');
        }
    }
}