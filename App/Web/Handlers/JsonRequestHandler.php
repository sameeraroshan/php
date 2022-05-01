<?php


namespace Serato\Web\Handlers;


use Psr\Http\Message\ServerRequestInterface;

abstract class  JsonRequestHandler extends AbstractRequestHandler
{

    /**Check whether http request handles JSON
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isValidContentType(ServerRequestInterface $request): bool
    {
        return $request->getHeader('Content-Type')[0] == 'application/json';
    }


}