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

final class NotFoundEvent extends Exception
{
    public static function withId(string $id): self
    {
        return new self(sprintf('Event with id "%s" can not be found.', $id));
    }
}
