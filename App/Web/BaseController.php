<?php

namespace Serato\Web;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


abstract class BaseController
{
    //content type identifier. can be moved to enum since PHP 8.1
    const JSON = 0;
    const HTML_FORM = 1;
    const HTML_RESOURCE = 2; //todo: use for html files, js files, images etc.

    /** process the client requests and sends the response back to client.
     * supports both HTML and JSON content types.
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface updated response
     */
    public function execute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        if ($this->isJsonRequest($request)) {
            $contentType = self::JSON;
        } else if ($this->isHtmlFormRequest($request)) {
            $contentType = self::HTML_FORM;
        } else {
            return $response->withStatus('405', 'Content type not supported!');
        }

        $method = strtoupper($request->getMethod());

        return match ($method) {
            "GET" => $this->getRequestHandler($request, $response, $contentType),
            "POST" => $this->postRequestHandler($request, $response, $contentType),
            "PUT" => $this->putRequestHandler($request, $response, $contentType),
            default => $response->withStatus('405', 'Method not supported!'), // block DELETE,PATCH etch
        };
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

    protected abstract function getRequestHandler(ServerRequestInterface $request, ResponseInterface $response, $contentType): ResponseInterface;

    protected abstract function postRequestHandler(ServerRequestInterface $request, ResponseInterface $response, $contentType): ResponseInterface;

    protected abstract function putRequestHandler(ServerRequestInterface $request, ResponseInterface $response, $contentType): ResponseInterface;
}