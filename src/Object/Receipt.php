<?php

declare(strict_types=1);

namespace Grokhotov\ATOL\Object;

/**
 * Class Receipt.
 *  «Приход», «Возврат прихода», «Расход», «Возврат расхода»
 *
 * @package Grokhotov\ATOL\Object
 */
class Receipt implements \JsonSerializable
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Company
     */
    private $company;

    /**
     * @var array
     */
    private $items = [];

    /**
     * @var array
     */
    private $payments = [];

    /**
     * @var float
     */
    private $total = 0.0;

    /**
     * @var array
     */
    private $vats = null;

    /**
     * Информация об агенте
     *
     * @var AgentInfo
     */
    private $agent_info;

    /**
     * Информация о поставщике
     *
     * @var SupplierInfo
     */
    private $supplier_info;

    /**
     * ФИО кассира.
     * Максимальная длина строки – 64 символа.
     *
     * @var string|null
     */
    private $cashier;

    /**
     * Дополнительный реквизит пользователя
     *
     * @var UserProp|null
     */
    private $additional_user_props;

    /**
     * Дополнительный реквизит чека.
     * Максимальная длина строки – 16 символов.
     * @var string
     */
    private $additional_check_props;
    private $isCorrection = false;
    private $baseDate;


    /**
     * @return UserProp|null
     */
    public function getAdditionalUserProps(): ?UserProp
    {
        return $this->additional_user_props;
    }


    /**
     * @param string $name
     * @param string $value
     * @return Receipt
     */
    public function setAdditionalUserProps(string $name, string $value): Receipt
    {
        $this->additional_user_props = new UserProp($name, $value);

        return $this;
    }


    /**
     * @return string
     */
    public function getAdditionalCheckProps(): ?string
    {
        return $this->additional_check_props;
    }


    public function setAdditionalCheckProps(?string $additional_check_props): Receipt
    {
        $this->additional_check_props = $additional_check_props;

        return $this;
    }


    /**
     * @return array|null
     */
    public function getVats(): ?array
    {
        return $this->vats;
    }


    /**
     * @param array $vats
     *
     * @return Receipt
     */
    public function setVats(array $vats): self
    {
        $this->vats = $vats;
        return $this;
    }


    /**
     * @param $vat
     *
     * @return Receipt
     */
    public function addVat($vat): self
    {
        $this->vats[] = $vat;
        return $this;
    }


    /**
     * @return AgentInfo
     */
    public function getAgentInfo(): ?AgentInfo
    {
        return $this->agent_info;
    }


    /**
     * @param ?AgentInfo $agent_info
     *
     * @return Receipt
     */
    public function setAgentInfo(?AgentInfo $agent_info): self
    {
        $this->agent_info = $agent_info;
        return $this;
    }


    /**
     * @return SupplierInfo
     */
    public function getSupplierInfo()
    {
        return $this->supplier_info;
    }


    /**
     * @param SupplierInfo $supplier_info
     *
     * @return Receipt
     */
    public function setSupplierInfo(SupplierInfo $supplier_info): self
    {
        $this->supplier_info = $supplier_info;
        return $this;
    }


    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }


    /**
     * @param array $items
     *
     * @return Receipt
     */
    public function setItems(array $items): Receipt
    {
        foreach ($items as $element) {
            $this->addItem($element);
        }

        return $this;
    }


    /**
     * @return float
     */
    public function getTotal(): float
    {
        return $this->total;
    }


    /**
     * @return array
     */
    public function getPayments(): array
    {
        return $this->payments;
    }


    /**
     * @param array $payments
     *
     * @return Receipt
     */
    public function setPayments(array $payments): Receipt
    {
        $this->payments = $payments;
        return $this;
    }


    /**
     * @return string|null
     */
    public function getCashier(): ?string
    {
        return $this->cashier;
    }


    /**
     * ФИО кассира.
     * Максимальная длина строки – 64 символа.
     *
     * @param string $cashier
     *
     * @return Receipt
     */
    public function setCashier(string $cashier): self
    {
        $this->cashier = mb_substr($cashier, 64);
        return $this;
    }


    /**
     * @param Item $item
     *
     * @return Receipt
     */
    public function addItem(Item $item): self
    {
        $this->items[] = $item;
        $this->addTotal($item->getSum());
        return $this;
    }


    /**
     * @param float $sum
     */
    private function addTotal($sum): self
    {
        $this->total += $sum;
        return $this;
    }


    /**
     * @param Payment $payment
     *
     * @return Receipt;
     */
    public function addPayment(Payment $payment): self
    {
        $this->payments[] = $payment;
        return $this;
    }


    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param Company $company
     * @return Receipt
     */
    public function setCompany(Company $company): self
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     * @return Receipt
     */
    public function setClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCorrection(): bool
    {
        return $this->isCorrection;
    }

    /**
     * @param bool $isCorrection
     * @return Receipt
     */
    public function setIsCorrection(bool $isCorrection): self
    {
        $this->isCorrection = $isCorrection;

        return $this;
    }


    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'client' => $this->getClient(),
            'company' => $this->getCompany(),
            'items' => $this->getItems(),
            'total' => round($this->getTotal(), 2),
            'payments' => $this->getPayments(),
            'cashier ' => $this->getCashier(),
            'vats' => $this->getVats(),
            'agent_info' => $this->getAgentInfo(),
            'supplier_info' => $this->getSupplierInfo(),
            'correction_info' => $this->getCorrectionInfo(),
            'additional_user_props' => $this->getAdditionalUserProps(),
            'additional_check_props' => $this->getAdditionalCheckProps(),
        ], static function ($property) {
            return !is_null($property);
        });
    }

    private function getCorrectionInfo(): ?array
    {
        if (!$this->isCorrection) {
            return null;
        }

        return [
            'type' => 'self',
            'base_date' => $this->getBaseDate(),
        ];
    }

    private function getBaseDate(): string
    {
        return $this->baseDate;
    }

    public function setBaseDate(string $baseDate): Receipt
    {
        $this->baseDate = $baseDate;

        return $this;
    }
}
