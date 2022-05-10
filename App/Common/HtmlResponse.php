<?php


namespace Serato\Common;


use Psr\Http\Message\ResponseInterface;

trait HtmlResponse
{
  use ResponseHandler;
    /** Sends the given HTML $content response to client
     * @param ResponseInterface $response
     * @param $content
     * @return mixed
     */
    public function handle(ResponseInterface $response, $content): ResponseInterface
    {
        $response->getBody()->write($content);
        $response = $response->withStatus(200)
            ->withHeader('Content-Type', 'text/html; charset=utf-8');
        return $response;
    }
}