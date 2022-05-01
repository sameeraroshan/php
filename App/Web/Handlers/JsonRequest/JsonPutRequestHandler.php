<?php


namespace Serato\Web\Handlers\JsonRequest;


class JsonPutRequestHandler extends JsonPostRequestHandler
{

    public function httpMethod(): string
    {
        return "PUT";
    }

}