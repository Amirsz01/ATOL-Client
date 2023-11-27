<?php

declare(strict_types=1);

namespace Grokhotov\ATOL\Request;

use Exception;
use Grokhotov\ATOL\Response\ReportResponse;
use Grokhotov\ATOL\Response\ResponseInterface;
use Grokhotov\ATOL\Response\TokenResponse;

/**
 * Class ReportRequest.
 *
 * @package Grokhotov\ATOL\Request
 */
class ReportRequest implements RequestInterface
{
    /**
     * @var string
     */
    private $groupId;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $token;


    /**
     * ReportRequest constructor.
     *
     * @param               $groupId
     * @param               $uuid
     * @param TokenResponse $token
     */
    public function __construct($groupId, $uuid, TokenResponse $token)
    {
        $this->groupId = $groupId;
        $this->uuid = $uuid;
        $this->token = $token->getToken();
    }


    /**
     * @return string
     */
    public function getMethod(): string
    {
        return self::METHOD_GET;
    }


    /**
     * @return array
     */
    public function getParams(): array
    {
        return [];
    }


    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->groupId . '/report/' . $this->uuid . '?token=' . $this->token;
    }


    /**
     * @param $response
     *
     * @throws Exception
     * @return ReportResponse
     *
     */
    public function getResponse($response): ResponseInterface
    {
        if (isset($response->error)) {
            throw new Exception(
                $response->error->text,
                $response->error->code
            );
        }

        return new ReportResponse($response);
    }
}
