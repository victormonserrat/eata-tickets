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

namespace EataDevTest\Domain\Order\Exception;

use DomainException;

final class InvalidOrder extends DomainException
{
    public static function causeUndefinedAttribute(string $attribute): self
    {
        return new self(sprintf('%s is not defined.', $attribute));
    }

    public static function causeUnexpectedAttributeType(string $attribute, string $expectedType): self
    {
        return new self(sprintf('%s has not %s type.', $attribute, $expectedType));
    }

    public static function causeEmptyAttribute(string $attribute): self
    {
        return new self(sprintf('%s can not be empty.', $attribute));
    }
}
