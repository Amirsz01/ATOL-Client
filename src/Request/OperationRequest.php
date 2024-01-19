<?php

declare(strict_types=1);

namespace Grokhotov\ATOL\Request;

use Exception;
use Grokhotov\ATOL\Object\Info;
use Grokhotov\ATOL\Object\Receipt;
use Grokhotov\ATOL\Response\OperationResponse;
use Grokhotov\ATOL\Response\ResponseInterface;
use Grokhotov\ATOL\Response\TokenResponse;

/**
 * Class OperationRequest.
 *
 * @package Grokhotov\ATOL\Request
 */
class OperationRequest implements RequestInterface
{
    public const OPERATION_SELL = 'sell';
    public const OPERATION_SELL_REFUND = 'sell_refund';
    public const OPERATION_SELL_CORRECTION = 'sell_correction';
    public const OPERATION_SELL_REFUND_CORRECTION = 'sell_refund_correction';
    public const OPERATION_BUY = 'buy';
    public const OPERATION_BUY_REFUND = 'buy_refund';
    public const OPERATION_BUY_REFUND_CORRECTION = 'buy_refund_correction';
    public const OPERATION_BUY_CORRECTION = 'buy_correction';

    private $groupId;

    private $uuid;

    private $receipt;

    private $info;

    private $token;

    private $operation;

    public function __construct(
        $groupId,
        $operation,
        $uuid,
        Receipt $receipt,
        Info $info,
        TokenResponse $token
    )
    {
        $this->groupId = $groupId;
        $this->operation = $operation;
        $this->uuid = $uuid;
        $this->receipt = $receipt;
        $this->info = $info;
        $this->token = $token->getToken();
    }


    /**
     * @return string
     */
    public function getMethod(): string
    {
        return self::METHOD_POST;
    }


    /**
     * @return array
     */
    public function getParams(): array
    {
        $isCorrection = in_array($this->operation, [
            self::OPERATION_SELL_CORRECTION,
            self::OPERATION_SELL_REFUND_CORRECTION,
            self::OPERATION_BUY_REFUND_CORRECTION,
            self::OPERATION_BUY_CORRECTION,
        ], true);

        $receiptProperty = $isCorrection ? 'correction' : 'receipt';
        $this->receipt->setIsCorrection($isCorrection);

        $params = [
            'timestamp' => date('d.m.Y H:i:s'),
            'external_id' => $this->uuid,
            'service' => $this->info,
            $receiptProperty => $this->receipt,
        ];

        return [
            'json' => $params,
            'headers' => [
                'Token' => $this->token,
            ],
        ];
    }


    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->groupId . '/' . $this->operation . '?token=' . $this->token;
    }


    /**
     * @param $response
     *
     * @return OperationResponse
     *
     * @throws Exception
     */
    public function getResponse($response): ResponseInterface
    {
        // при попытке повторной регистрации чека, АТОЛ возвращает код ошибки 33 и UUID чека,
        // который можно вернуть как нормальный ответ, вместо исключения
        if (isset($response->error) && (int)$response->error->code !== 33) {
            throw new Exception(
                $response->error->text,
                $response->error->code
            );
        }

        return new OperationResponse($response);
    }
}
