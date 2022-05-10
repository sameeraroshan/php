<?php


namespace Serato\Web\Handlers;


use Psr\Http\Message\ServerRequestInterface;
use Serato\Common\JsonResponse;
use Serato\Common\ValidityChecker;

abstract class  JsonRequestHandler implements RequestHandler
{   use ValidityChecker;
    use JsonResponse;

    /**Check whether http request handles JSON
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isValidContentType(ServerRequestInterface $request): bool
    {
        return $request->getHeader('Content-Type')[0] == 'application/json';
    }


}