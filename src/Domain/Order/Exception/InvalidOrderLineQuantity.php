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

final class InvalidOrderLineQuantity extends DomainException
{
    public static function causeLessThanOne(): self
    {
        return new self('Line quantity can not be less than one.');
    }
}
