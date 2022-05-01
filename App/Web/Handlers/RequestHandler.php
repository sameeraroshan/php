<?php


namespace Serato\Web\Handlers;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RequestHandler
{

    public function httpMethod():string;
    public function execute(ServerRequestInterface $request, ResponseInterface $response,$contentType): ResponseInterface;
    public function htmlResponse(ResponseInterface $response, $content): ResponseInterface;
    public function jsonResponse(ResponseInterface $response, $content): ResponseInterface;
}