<?php

declare(strict_types=1);

namespace Grokhotov\ATOL\Object;

/**
 * Class Item.
 *
 * @package Grokhotov\ATOL\Object
 */
class Item implements \JsonSerializable
{

    private const MARK_PROCESSING_MODE = "0";

    private $sum = 0.0;

    private $vat;

    private $vatSum;

    private $name = '';

    private $price = 0.0;

    private $quantity = 1.0;
    /**
     * @var string $payment_object Признак предмета расчета
     */
    private $payment_object = PaymentObject::PAYMENT_OBJECT_PREPAY;
    /**
     * @var string $payment_method Признак способа расчета
     */
    private $payment_method = PaymentMethod::FULL_PREPAYMENT;
    /**
     * @var string $measurement_unit Единица измерения предмета расчета
     */
    private $measure = 0;

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
     * Информация о маркировке
     *
     * @var string
     */
    private $mark;

    /**
     * Дополнительный реквизит предмета расчета
     *
     * @var string
     */
    private $userData;

    /**
     * Продаваемый товар по чеку.
     *
     * @param string $name
     * @param float $price
     * @param float $quantity
     * @param string $vat
     * @param int $payment_object
     * @param string $payment_method
     * @param string|null $mark
     */
    public function __construct(
        string  $name,
        float   $price,
        float   $quantity,
        string  $vat,
        int     $payment_object = 0,
        string  $payment_method = PaymentMethod::FULL_PAYMENT,
        ?string $mark = null
    )
    {
        $this->setName($name);
        $this->setPrice($price);
        $this->setQuantity($quantity);
        $this->setVat($vat);
        $this->setSum(round($price * $quantity, 2));
        $this->setPaymentObject($payment_object);
        $this->setPaymentMethod($payment_method);
        if ($mark) {
            $this->setMark($mark);
        }
    }


    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $result = [
            'name' => $this->getName(),
            'price' => round($this->getPrice(), 2),
            'quantity' => $this->getQuantity(),
            'sum' => round($this->getSum(), 2),
            'vat' => [
                'type' => $this->getVat(),
                'sum' => round($this->getVatSum(), 2),
            ],
            'payment_object' => $this->getPaymentObject(),
            'payment_method' => $this->getPaymentMethod(),
            'agent_info' => $this->getAgentInfo(),
            'measure' => $this->getMeasure(),
            'supplier_info' => $this->getSupplierInfo(),
            'user_data' => $this->getUserData(),
        ];

        if ($this->getMark()) {
            $result['mark_code'] = $this->getMark();
            $result['mark_processing_mode'] = self::MARK_PROCESSING_MODE;
        }

        return array_filter($result, static function ($property) {
            return !is_null($property);
        });
    }

    /**
     * @return AgentInfo|null
     */
    public function getAgentInfo(): ?AgentInfo
    {
        return $this->agent_info;
    }


    /**
     * @param AgentInfo $agent_info
     *
     * @return Item
     */
    public function setAgentInfo(AgentInfo $agent_info): self
    {
        $this->agent_info = $agent_info;
        return $this;
    }


    /**
     * @return SupplierInfo
     */
    public function getSupplierInfo(): ?SupplierInfo
    {
        return $this->supplier_info;
    }


    /**
     * @param SupplierInfo $supplier_info
     *
     * @return Item
     */
    public function setSupplierInfo(SupplierInfo $supplier_info): self
    {
        $this->supplier_info = $supplier_info;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param string $name
     *
     * @return Item
     */
    public function setName(string $name): self
    {
        $this->name = mb_substr($name, 0, 128);
        return $this;
    }


    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }


    /**
     * @param float $price
     *
     * @return Item
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }


    /**
     * @return float
     */
    public function getQuantity(): float
    {
        return $this->quantity;
    }


    /**
     * @param float $quantity
     *
     * @return Item
     */
    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVat(): ?string
    {
        return $this->vat;
    }

    /**
     * @param string $vat
     *
     * @return Item
     */
    public function setVat(string $vat): Item
    {

        $this->vat = $vat;
        switch ($vat) {
            case (Vat::TAX_VAT110):
                $this->setVatSum($this->getPrice() * $this->getQuantity() * 10 / 110);
                break;
            case (Vat::TAX_VAT118):
                $this->setVatSum($this->getPrice() * $this->getQuantity() * 18 / 118);
                break;
            case (Vat::TAX_VAT10):
                $this->setVatSum($this->getPrice() * $this->getQuantity() * 0.1);
                break;
            case (Vat::TAX_VAT10Z):
                $this->setVatSum($this->getPrice() * $this->getQuantity() * 10 / 110);
                $this->vat = Vat::TAX_VAT10;
                break;
            case (Vat::TAX_VAT18):
                $this->setVatSum($this->getPrice() * $this->getQuantity() * 0.18);
                break;
            case (Vat::TAX_VAT20):
                $this->setVatSum($this->getPrice() * $this->getQuantity() * 0.2);
                break;
            case (Vat::TAX_VAT22):
                $this->setVatSum($this->getPrice() * $this->getQuantity() * 0.22);
                break;
            case (Vat::TAX_VAT20Z):
                $this->setVatSum($this->getPrice() * $this->getQuantity() * 20 / 120);
                $this->vat = Vat::TAX_VAT20;
                break;
            case (Vat::TAX_VAT120):
                $this->setVatSum($this->getPrice() * $this->getQuantity() * 20 / 120);
                break;
            case (Vat::TAX_VAT122):
                $this->setVatSum($this->getPrice() * $this->getQuantity() * 22 / 122);
                break;
            case (Vat::TAX_VAT0):
            case (Vat::TAX_NONE):
            default:
                $this->setVatSum(0);
        }

        return $this;
    }

    /**
     * @return float
     */
    public function getVatSum(): float
    {
        return $this->vatSum;
    }


    /**
     * @param float $vatSum
     */
    public function setVatSum(float $vatSum): void
    {
        $this->vatSum = round($vatSum, 2);
    }


    /**
     * @return float
     */
    public function getSum(): float
    {
        return $this->sum;
    }


    /**
     * @param float $sum
     *
     * @return Item
     */
    public function setSum(float $sum): self
    {
        $this->sum = $sum;
        return $this;
    }


    /**
     * @return int
     */
    public function getPaymentObject(): int
    {
        return $this->payment_object;
    }


    /**
     * @param int $payment_object
     *
     * @return Item
     */
    public function setPaymentObject(int $payment_object): self
    {
        $this->payment_object = $payment_object;
        return $this;
    }


    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->payment_method;
    }


    /**
     * @param string $payment_method
     *
     * @return Item
     */
    public function setPaymentMethod(string $payment_method): self
    {
        $this->payment_method = $payment_method;
        return $this;
    }


    /**
     * @return int
     */
    public function getMeasure(): int
    {
        return $this->measure;
    }


    /**
     * @param int $measure
     *
     * @return Item
     */
    public function setMeasure(int $measure): self
    {
        $this->measure = $measure;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getMark(): ?array
    {
        $mark = $this->mark;
        if ($mark && strlen($mark) > 50) {
            return ['gs1m' => $mark];
        }

        if ($mark) {
            if (strpos($mark, '==') === strlen($mark) - 2) {
                $mark = base64_decode($mark);
            }
            return ['short' => $mark];
        }

        return null;
    }


    /**
     * @param string|null $mark
     *
     * @return Item
     */
    public function setMark(?string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }


    public function getUserData(): ?string
    {
        return $this->userData;
    }

    public function setUserData(string $userData): self
    {
        $this->userData = $userData;

        return $this;
    }
}
