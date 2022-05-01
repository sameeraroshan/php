<?php


namespace Serato\Web;

use Serato\Common\ValidityChecker;
use Serato\Web\Handlers\FormRequest\FormGetRequestHandler;
use Serato\Web\Handlers\FormRequest\FormPostRequestHandler;
use Serato\Web\Handlers\FormRequest\FormPutRequestHandlerForm;
use Serato\Web\Handlers\JsonRequest\JsonGetRequestHandler;
use Serato\Web\Handlers\JsonRequest\JsonPostRequestHandler;
use Serato\Web\Handlers\JsonRequest\JsonPutRequestHandler;

class Controller extends BaseController
{
    use ValidityChecker;

    function init()
    {   //form value handlers
        $this->registerRequestHandler(new FormGetRequestHandler());
        $this->registerRequestHandler(new FormPostRequestHandler());
        $this->registerRequestHandler(new FormPutRequestHandlerForm());
        // json value handlers
        $this->registerRequestHandler(new JsonGetRequestHandler());
        $this->registerRequestHandler(new JsonPostRequestHandler());
        $this->registerRequestHandler(new JsonPutRequestHandler());

    }
}