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

namespace EataDevTest\Application\Repository;

use EataDevTest\Domain\Event\Model\Event;

interface Events
{
    /** @return Event[] */
    public function all();

    public function save(): void;
}
