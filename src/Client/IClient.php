<?php

declare(strict_types=1);

namespace Grokhotov\ATOL\Client;

use Grokhotov\ATOL\Request\OperationRequest;
use Grokhotov\ATOL\Request\ReportRequest;
use Grokhotov\ATOL\Request\RequestInterface;
use Grokhotov\ATOL\Request\TokenRequest;
use Grokhotov\ATOL\Response\OperationResponse;
use Grokhotov\ATOL\Response\ReportResponse;
use Grokhotov\ATOL\Response\TokenResponse;

/**
 * Interface IClient.
 *
 * @package Grokhotov\ATOL\Client
 */
interface IClient
{
    /**
     * @param RequestInterface $request
     *
     * @return string
     */
    public function makeRequest(RequestInterface $request): string;


    /**
     * @param TokenRequest $request
     *
     * @return TokenResponse
     */
    public function getToken(TokenRequest $request): TokenResponse;


    /**
     * @param OperationRequest $request
     *
     * @return OperationResponse
     */
    public function doOperation(OperationRequest $request): OperationResponse;


    /**
     * @param ReportRequest $request
     *
     * @return ReportResponse
     */
    public function getReport(ReportRequest $request): ReportResponse;
}
