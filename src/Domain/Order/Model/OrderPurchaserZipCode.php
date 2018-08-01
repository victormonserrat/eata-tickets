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

use EataDevTest\Domain\Order\Exception\InvalidOrderPurchaserZipCode;
use EataDevTest\Domain\ValueObject;

final class OrderPurchaserZipCode implements ValueObject
{
    /** @var string */
    private $zipCode;

    public static function fromString(string $zipCode): self
    {
        return new self($zipCode);
    }

    private function __construct(string $zipCode)
    {
        if (empty($zipCode)) {
            throw InvalidOrderPurchaserZipCode::causeEmptyString();
        }

        $this->zipCode = $zipCode;
    }

    public function toString(): string
    {
        return $this->zipCode;
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return get_class($this) === get_class($valueObject) && $this->toString() === $valueObject->toString();
    }
}
