<?php


namespace Serato\Web\Handlers\FormRequest;



class FormPutRequestHandlerForm extends FormPostRequestHandler
{

    public function httpMethod(): string
    {
        return "PUT";
    }

}