<?php

declare(strict_types=1);

namespace Grokhotov\ATOL\Client;

use Exception;
use Grokhotov\ATOL\Request\CorrectionRequest;
use Grokhotov\ATOL\Request\OperationRequest;
use Grokhotov\ATOL\Request\ReportRequest;
use Grokhotov\ATOL\Request\RequestInterface;
use Grokhotov\ATOL\Request\TokenRequest;
use Grokhotov\ATOL\Response\OperationResponse;
use Grokhotov\ATOL\Response\ReportResponse;
use Grokhotov\ATOL\Response\TokenResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use function json_decode;
use function json_encode;
use function json_last_error;

/**
 * Class ApiClient.
 *
 * @package Grokhotov\ATOL\Client
 */
class ApiClient implements IClient
{
    private const API_URL = 'https://online.atol.ru/possystem/';

    private $http;

    /**
     * @var string
     */
    private $version = 'v5';


    /**
     * ApiClient constructor.
     *
     * @param Client|null $client
     */
    public function __construct(Client $client = null, $version = 'v5')
    {
        $this->http = $client;

        if (null === $client) {
            $this->http = new Client([
                'base_uri' => self::API_URL . $version . "/",
            ]);
        }
    }

    public static function createClient(string $version = 'v5'): ApiClient
    {
        return new self(
            new Client([
                'base_uri' => self::API_URL . $version . "/",
            ])
        );
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }


    /**
     * @param string $version
     */
    public function setVersion(string $version): void
    {
        $this->version = $version;
    }


    /**
     * @param TokenRequest $request
     *
     * @return TokenResponse
     * @throws Exception
     */
    public function getToken(TokenRequest $request): TokenResponse
    {
        return $request->getResponse(
            json_decode($this->makeRequest(
                $request
            ), false)
        );
    }


    /**
     * @param RequestInterface $request
     *
     * @return string
     */
    public function makeRequest(RequestInterface $request): string
    {
        try {
            $response = $this->http->request(
                $request->getMethod(),
                $request->getUrl(),
                $request->getParams()
            );

            $message = $response->getBody()->getContents();
        } catch (BadResponseException $exception) {
            $response = $exception->getResponse();
            if ($response) {
                $message = $response->getBody()->getContents();
                json_decode($message, false);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $message = json_encode(
                        [
                            'error' => [
                                'code' => $exception->getCode(),
                                'text' => $exception->getMessage(),
                            ],
                        ]
                    );
                }
            } else {
                $message = json_encode(
                    [
                        'error' => [
                            'code' => $exception->getCode(),
                            'text' => $exception->getMessage(),
                        ],
                    ]
                );
            }
        } catch (GuzzleException $exception) {
            $message = json_encode(
                [
                    'error' => [
                        'code' => $exception->getCode(),
                        'text' => $exception->getMessage(),
                    ],
                ]
            );
        }

        return $message;
    }


    /**
     * @param OperationRequest $request
     *
     * @return OperationResponse
     *
     * @throws Exception
     */
    public function doOperation(OperationRequest $request): OperationResponse
    {
        return $request->getResponse(
            json_decode($this->makeRequest(
                $request
            ), false)
        );
    }


    public function doCorrection(CorrectionRequest $request): OperationResponse
    {
        return $request->getResponse(
            json_decode($this->makeRequest(
                $request
            ), false)
        );
    }


    /**
     * @param ReportRequest $request
     *
     * @return ReportResponse
     * @throws Exception
     */
    public function getReport(ReportRequest $request): ReportResponse
    {
        return $request->getResponse(
            json_decode($this->makeRequest(
                $request
            ), false)
        );
    }

}
