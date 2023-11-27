<?php

declare(strict_types=1);

namespace Grokhotov\ATOL\Request;

use Grokhotov\ATOL\Response\ResponseInterface;

/**
 * Interface RequestInterface.
 *
 * @package Grokhotov\ATOL\Request
 */
interface RequestInterface
{
    public const METHOD_POST = 'POST';
    public const METHOD_GET = 'GET';


    /**
     * @return string
     */
    public function getMethod(): string;


    /**
     * @return array
     */
    public function getParams(): array;


    /**
     * @return string
     */
    public function getUrl(): string;


    /**
     * @param $response
     *
     * @return ResponseInterface
     */
    public function getResponse($response): ResponseInterface;
}
