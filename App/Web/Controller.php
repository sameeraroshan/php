<?php


namespace Serato\Web;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Serato\Common\ValidityChecker;

class Controller extends BaseController
{
    use ValidityChecker;

    /** GET request handler.GET requests are used with query params. therefore request body is ignored.
     * query params are sent back to the client
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $contentType
     * @return ResponseInterface
     */
    protected function getRequestHandler(ServerRequestInterface $request, ResponseInterface $response, $contentType): ResponseInterface
    {
        //$request body is ignored since this is get request
        $queryParams = $request->getQueryParams();
        switch ($contentType) {
            case self::JSON;
                //converting query params to json object and sent it back.
                $response = $this->jsonResponse($response, $queryParams);
                break;
            case self::HTML_FORM;
                $message = "<h1>Html Response</h1></br><h2> Html response for GET request" . json_encode($queryParams) . "</h2>";
                $response = $this->htmlResponse($response, $message);
                break;
        }
        return $response;
    }

    /**
     * POST request handler. POST content are sent though request body.Therefore request body is parsed based on its
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $contentType
     * @return ResponseInterface
     */
    protected function postRequestHandler(ServerRequestInterface $request, ResponseInterface $response, $contentType): ResponseInterface
    {
        switch ($contentType) {
            case self::JSON;
                //check request body is a valid json
                if ($this->isValidJson((string)$request->getBody())) {
                    //sending back requested json.
                    $response = $this->jsonResponse($response, (string)$request->getBody());
                } else {
                    $response = $response->withStatus('400', 'Bad JSON Content');
                }

                break;
            case self::HTML_FORM;
                if ($this->isValidForm($request->getParsedBody())) {
                    $message = "<h1>Html Response</h1></br><h2> Html response</h2>";
                    $response = $this->htmlResponse($response, $message);
                } else {
                    $response = $response->withStatus('400', 'Bad Form Data Content');
                }

                break;
        }
        return $response;
    }

    /** request is considered as equal to POST.rerouted to POST handler
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $contentType
     * @return ResponseInterface
     */
    protected function putRequestHandler(ServerRequestInterface $request, ResponseInterface $response, $contentType): ResponseInterface
    {
        return $this->postRequestHandler($request, $response, $contentType);
    }
}