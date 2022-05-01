<?php


namespace Serato\Web\Handlers\JsonRequest;


class PutRequestHandler extends PostRequestHandler
{

    public function httpMethod(): string
    {
        return "PUT";
    }

}