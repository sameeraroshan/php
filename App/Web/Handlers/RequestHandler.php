<?php


namespace Serato\Web\Handlers;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RequestHandler
{
    public function isValidContentType(ServerRequestInterface $request): bool;

    public function httpMethod(): string;

    public function execute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;

    public function htmlResponse(ResponseInterface $response, $content): ResponseInterface;

    public function jsonResponse(ResponseInterface $response, $content): ResponseInterface;
}