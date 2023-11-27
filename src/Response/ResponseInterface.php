<?php

declare(strict_types=1);

namespace Grokhotov\ATOL\Response;

use stdClass;

/**
 * Interface ResponseInterface.
 *
 * @package Grokhotov\ATOL\Response
 */
interface ResponseInterface
{
    /**
     * ResponseInterface constructor.
     *
     * @param stdClass $json
     */
    public function __construct(stdClass $json);
}
