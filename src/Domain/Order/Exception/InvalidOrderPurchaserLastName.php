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

final class InvalidOrderPurchaserLastName extends DomainException
{
    public static function causeEmptyString(): self
    {
        return new self('Purchaser last name can not be empty.');
    }
}
