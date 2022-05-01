<?php


namespace Serato\Web;

use Serato\Common\ValidityChecker;
use Serato\Web\Handlers\FormRequest\GetRequestHandler;
use Serato\Web\Handlers\FormRequest\PostRequestHandler;
use Serato\Web\Handlers\FormRequest\PutRequestHandler;

class Controller extends BaseController
{
    use ValidityChecker;

    function init()
    {
        $this->registerRequestHandler(new GetRequestHandler());
        $this->registerRequestHandler(new PostRequestHandler());
        $this->registerRequestHandler(new PutRequestHandler());

    }
}