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

namespace EataDevTest\Domain\Ticket\Model;

use EataDevTest\Domain\ValueObject;

final class TicketPrice implements ValueObject
{
    /** @var int */
    private $price;

    public static function fromInteger(int $price): self
    {
        return new self($price);
    }

    private function __construct(int $price)
    {
        $this->price = $price;
    }

    public function toInteger(): int
    {
        return $this->price;
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return get_class($this) === get_class($valueObject) && $this->toInteger() === $valueObject->toInteger();
    }
}
