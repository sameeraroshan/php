<?php


namespace Serato\Common;


use Psr\Http\Message\ResponseInterface;

trait ResponseHandler
{
  abstract function handle(ResponseInterface $response, $content): ResponseInterface;
}