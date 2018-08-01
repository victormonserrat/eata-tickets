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

namespace EataDevTest\Application\Exception;

use Exception;

final class NotValidatedCode extends Exception
{
    public static function causeValidatedAt(string $date, string $orderId): self
    {
        return new self(sprintf('Code was already validated at %s (Order id: %s).', $date, $orderId));
    }
}
