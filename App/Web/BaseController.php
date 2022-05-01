<?php

namespace Serato\Web;


use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Serato\Web\Handlers\ContentTypes;
use Serato\Web\Handlers\HandlerService;
use Serato\Web\Handlers\RequestHandler;
use stdClass;


abstract class BaseController
{
    private object $handlerService;

    #[Pure] public function __construct()
    {
        $this->handlerService = new HandlerService();
    }

    /** registers the request handlers as a property in $requestHandlers object.
     * eg GET-> getHandler, POST-> post handler
     * @param RequestHandler $requestHandler
     */
    public function registerRequestHandler(RequestHandler $requestHandler)
    {
        $this->handlerService->register($requestHandler);
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
        $handlers = $this->handlerService->getHandler($method, $request);
        if (count($handlers) > 0) {
            foreach ($handlers as $handler) {
                return $handler->execute($request, $response);
            }
        } else {
            return $response->withStatus('405', 'Method not supported!'); // block DELETE,PATCH etch
        }
    }

    abstract function init();

}