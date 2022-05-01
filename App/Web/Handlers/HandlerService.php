<?php


namespace Serato\Web\Handlers;

use JetBrains\PhpStorm\Pure;

class HandlerService
{
    private $handlers;

    #[Pure] public function __construct()
    {
        $this->handlers = [];
    }

    /** register request handlers
     * @param RequestHandler $handler
     */
    function register(RequestHandler $handler)
    {  //todo need to add check for duplicates
        array_push($this->handlers, $handler);
    }

    /** return the corrent handler based on method and content type
     * @param $method
     * @param $request
     * @return array
     */
    function getHandler($method, $request): array
    {
        return array_filter($this->handlers,
            fn($handler) => $handler->httpMethod() == $method && $handler->isValidContentType($request));
    }

}