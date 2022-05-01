<?php


namespace Serato\Web\Handlers;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostRequestHandler extends AbstractRequestHandler
{

    public function httpMethod(): string
    {
        return "POST";
    }

    /**
     * POST request handler. POST content are sent though request body.Therefore request body is parsed based on its
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $contentType
     * @return ResponseInterface
     */
    public function execute(ServerRequestInterface $request, ResponseInterface $response, $contentType): ResponseInterface
    {
        switch ($contentType) {
            case ContentTypes::JSON;
                //check request body is a valid json
                if ($this->isValidJson((string)$request->getBody())) {
                    //sending back requested json.
                    $response = $this->jsonResponse($response, (string)$request->getBody());
                } else {
                    $response = $response->withStatus('400', 'Bad JSON Content');
                }
                return $response;
            case ContentTypes::HTML_FORM;
                if ($this->isValidForm($request->getParsedBody())) {
                    $message = "<h1>Html Response</h1></br><h2> Html response</h2>";
                    $response = $this->htmlResponse($response, $message);
                } else {
                    $response = $response->withStatus('400', 'Bad Form Data Content');
                }
                return $response;
            default:
                return $response->withStatus('405', 'Content type not supported!');
        }
    }
}