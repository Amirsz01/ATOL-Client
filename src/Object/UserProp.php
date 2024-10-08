<?php

declare(strict_types=1);

namespace Grokhotov\ATOL\Object;

/**
 * Class UserProp.
 *
 * @package Grokhotov\ATOL\Object
 */
class UserProp implements \JsonSerializable
{

    /**
     * Наименование дополнительного реквизита пользователя.
     * Максимальная длина строки – 64 символа.
     *
     * @var string
     */
    private $name;

    /**
     * Значение дополнительного реквизита пользователя.
     * Максимальная длина строки – 256 символов.
     *
     * @var string
     */
    private $value;


    /**
     * UserProp constructor.
     *
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->setName($name);
        $this->setValue($value);
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'name'  => $this->getName(),
            'value' => $this->getValue(),
        ];
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
     * @return UserProp
     */
    public function setName(string $name): self
    {
        $this->name = mb_substr($name, 0, 64);
        return $this;
    }


    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }


    /**
     * @param string $value
     *
     * @return UserProp
     */
    public function setValue(string $value): self
    {
        $this->value = mb_substr($value, 0, 256);
        return $this;
    }
}
