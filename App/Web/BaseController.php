<?php

namespace Serato\Web;


use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Serato\Web\Handlers\ContentTypes;
use Serato\Web\Handlers\RequestHandlerInterface;
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
     * @param RequestHandlerInterface $requestHandler
     */
    public function registerRequestHandler(RequestHandlerInterface $requestHandler)
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
            if ($this->requestHandlers->{$method}->isValidContent($request)){
                return $this->requestHandlers->{$method}->execute($request, $response);
            }
        } else {
            return $response->withStatus('405', 'Method not supported!'); // block DELETE,PATCH etch
        }
    }

    /** Check whether http request handles JSON
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isJsonRequest(ServerRequestInterface $request): bool
    {

    }



    abstract function init();

}