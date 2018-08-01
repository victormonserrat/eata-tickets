<?php

/*
 * This file is part of the EATA Dev Test package.
 *
 * (c) Victor Monserrat
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace EataDevTest\Domain\Order\Model;

use EataDevTest\Domain\Order\Exception\InvalidOrderLineQuantity;
use EataDevTest\Domain\ValueObject;

final class OrderLineQuantity implements ValueObject
{
    /** @var int */
    private $quantity;

    public static function fromInteger(int $quantity): self
    {
        return new self($quantity);
    }

    private function __construct(int $quantity = 1)
    {
        if ($quantity < 1) {
            throw InvalidOrderLineQuantity::causeLessThanOne();
        }

        $this->quantity = $quantity;
    }

    public function toInteger(): int
    {
        return $this->quantity;
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return get_class($this) === get_class($valueObject) && $this->toInteger() === $valueObject->toInteger();
    }
}
