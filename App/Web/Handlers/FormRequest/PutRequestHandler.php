<?php


namespace Serato\Web\Handlers\FormRequest;



class PutRequestHandler extends PostRequestHandler
{

    public function httpMethod(): string
    {
        return "PUT";
    }

}