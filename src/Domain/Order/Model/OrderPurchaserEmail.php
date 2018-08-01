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

use EataDevTest\Domain\Order\Exception\InvalidOrderPurchaserEmail;
use EataDevTest\Domain\ValueObject;

final class OrderPurchaserEmail implements ValueObject
{
    /** @var string */
    private $email;

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    private function __construct(string $email)
    {
        if (!filter_var($email, \FILTER_VALIDATE_EMAIL)) {
            throw InvalidOrderPurchaserEmail::causeInvalidString();
        }

        $this->email = $email;
    }

    public function toString(): string
    {
        return $this->email;
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return get_class($this) === get_class($valueObject) && $this->toString() === $valueObject->toString();
    }
}
