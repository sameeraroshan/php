<?php

namespace Serato\Web;


use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Serato\Web\Handlers\ContentTypes;
use Serato\Web\Handlers\RequestHandler;
use stdClass;


abstract class BaseController
{
    private object $requestHandlers;

    #[Pure] public function __construct()
    {
        $this->requestHandlers = new stdClass();
    }

    /** registers the request handlers as a property in $requestHandlers object.
     * eg GET-> getHandler, POST-> post handler
     * @param RequestHandler $requestHandler
     */
    public function registerRequestHandler(RequestHandler $requestHandler)
    {
        $this->requestHandlers->{strtoupper($requestHandler->httpMethod())} = $requestHandler;
    }


    /** process the client requests and sends the response back to client.
     * supports both HTML and JSON content types.
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface updated response
     */
    public function execute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $method = strtoupper($request->getMethod());
        if (property_exists($this->requestHandlers, $method)) {
            return $this->requestHandlers->{$method}->execute($request, $response, $this->getContentType($request));
        } else {
            return $response->withStatus('405', 'Method not supported!'); // block DELETE,PATCH etch
        }
    }

    public function getContentType(ServerRequestInterface $request)
    {
        if ($this->isJsonRequest($request)) {
            return ContentTypes::JSON;
        } else if ($this->isHtmlFormRequest($request)) {
            return ContentTypes::HTML_FORM;
        } else {
            return ContentTypes::UNDEFINED;
        }
    }


    /** Check whether http request handles JSON
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isJsonRequest(ServerRequestInterface $request): bool
    {
        return $request->getHeader('Content-Type')[0] == 'application/json';
    }

    /** Check whether http request handles HTML
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isHtmlFormRequest(ServerRequestInterface $request): bool
    {
        return $request->getHeader('Content-Type')[0] == 'multipart/form-data'
            || $request->getHeader('Content-Type')[0] == 'application/x-www-form-urlencoded';
    }

    abstract function init();

}