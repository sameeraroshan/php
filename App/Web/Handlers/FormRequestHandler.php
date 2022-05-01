<?php


namespace Serato\Web\Handlers;


use Psr\Http\Message\ServerRequestInterface;

abstract class FormRequestHandler extends AbstractRequestHandler
{

    public function getContentType(): int
    {
        return ContentTypes::FORM;
    }

    /** Check whether http request handles Form Data
     * @param ServerRequestInterface $request
     * @return bool
     */
    function isValidContentType(ServerRequestInterface $request): bool
    {
        return $request->getHeader('Content-Type')[0] == 'multipart/form-data'
            || $request->getHeader('Content-Type')[0] == 'application/x-www-form-urlencoded';
    }
}