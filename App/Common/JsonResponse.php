<?php


namespace Serato\Common;


use Psr\Http\Message\ResponseInterface;

trait JsonResponse
{
    use ResponseHandler;
    /** Sends the given JSON $content response to client
     * @param ResponseInterface $response
     * @param $content
     * @return mixed
     */
    public function handle(ResponseInterface $response, $content): ResponseInterface
    {
        $response->getBody()->write(json_encode($content));
        $response = $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }
}