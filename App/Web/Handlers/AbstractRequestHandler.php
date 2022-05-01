<?php


namespace Serato\Web\Handlers;


use Psr\Http\Message\ResponseInterface;
use Serato\Common\ValidityChecker;

abstract class AbstractRequestHandler implements RequestHandlerInterface
{
    use ValidityChecker;

    /** Sends the given HTML $content response to client
     * @param ResponseInterface $response
     * @param $content
     * @return mixed
     */
    public function htmlResponse(ResponseInterface $response, $content): ResponseInterface
    {
        $response->getBody()->write($content);
        $response = $response->withStatus(200)
            ->withHeader('Content-Type', 'text/html; charset=utf-8');
        return $response;
    }

    /** Sends the given JSON $content response to client
     * @param ResponseInterface $response
     * @param $content
     * @return mixed
     */
    public function jsonResponse(ResponseInterface $response, $content): ResponseInterface
    {
        $response->getBody()->write(json_encode($content));
        $response = $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }

}