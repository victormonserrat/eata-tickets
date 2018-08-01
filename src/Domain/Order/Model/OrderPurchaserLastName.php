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

use EataDevTest\Domain\Order\Exception\InvalidOrderPurchaserLastName;
use EataDevTest\Domain\ValueObject;

final class OrderPurchaserLastName implements ValueObject
{
    /** @var string */
    private $lastName;

    public static function fromString(string $lastName): self
    {
        return new self($lastName);
    }

    private function __construct(string $lastName)
    {
        if (empty($lastName)) {
            throw InvalidOrderPurchaserLastName::causeEmptyString();
        }

        $this->lastName = $lastName;
    }

    public function toString(): string
    {
        return $this->lastName;
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return get_class($this) === get_class($valueObject) && $this->toString() === $valueObject->toString();
    }
}
