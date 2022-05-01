<?php


namespace Serato\Web\Handlers;


class ContentTypes
{
    //content type identifier. can be moved to enum since PHP 8.1
    public const UNDEFINED = 0;
    public const JSON = 1;
    public const FORM = 2;
    public const HTML_RESOURCE = 3; //todo: use for html files, js files, images etc.
}