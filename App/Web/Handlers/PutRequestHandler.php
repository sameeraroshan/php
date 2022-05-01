<?php


namespace Serato\Web\Handlers;


class PutRequestHandler extends PostRequestHandler
{

    public function httpMethod(): string
    {
        return "PUT";
    }

}