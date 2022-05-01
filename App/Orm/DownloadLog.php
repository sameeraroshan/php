<?php

namespace Serato\Orm;

use Serato\Annotations\SeratoNumeric;
use Serato\Common\NumericValidator;

final class DownloadLog extends ActiveRecord
{
    use NumericValidator;


    /**
     * @SeratoNumeric
     */
    private $fileId;

    /**
     * @SeratoNumeric
     */
    private $userId;


}
