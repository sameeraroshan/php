<?php


namespace Serato\Web;

use Serato\Common\ValidityChecker;
use Serato\Web\Handlers\GetRequestHandler;
use Serato\Web\Handlers\PostRequestHandler;
use Serato\Web\Handlers\PutRequestHandler;

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