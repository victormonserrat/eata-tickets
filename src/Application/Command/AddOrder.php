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

namespace EataDevTest\Application\Command;

use EataDevTest\Domain\Order\Model\Order;

final class AddOrder
{
    /** @var array */
    private $content;

    public static function with(Order $order): self
    {
        return new self($order->toArray());
    }

    private function __construct(array $content)
    {
        $this->content = $content;
    }

    public function order(): Order
    {
        return Order::fromArray($this->content);
    }
}
