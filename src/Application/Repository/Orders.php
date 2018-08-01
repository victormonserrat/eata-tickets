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

use EataDevTest\Domain\Order\Model\Order;

interface Orders
{
    public function add(Order $order): Order;

    public function save(): void;
}
