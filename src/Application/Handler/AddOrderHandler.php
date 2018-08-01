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

namespace EataDevTest\Application\Handler;

use EataDevTest\Application\Command\AddOrder;
use EataDevTest\Application\Repository\Codes;
use EataDevTest\Application\Repository\Orders;
use EataDevTest\Application\Service\Notifier;
use EataDevTest\Domain\Code\Model\Code;
use EataDevTest\Domain\Code\Model\CodeId;
use EataDevTest\Domain\Code\Model\CodeOrderId;
use EataDevTest\Domain\Code\Model\CodeOrderLineId;
use EataDevTest\Domain\Code\Model\CodeTicketId;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class AddOrderHandler implements MessageHandlerInterface
{
    /** @var Orders */
    private $orders;

    /** @var Codes */
    private $codes;

    /** @var Notifier */
    private $notifier;

    public function __construct(Orders $orders, Codes $codes, Notifier $notifier)
    {
        $this->orders = $orders;
        $this->codes = $codes;
        $this->notifier = $notifier;
    }

    public function __invoke(AddOrder $command): void
    {
        $order = $this->orders->add($command->order());
        $codes = [];

        foreach ($order->lines() as $line) {
            for ($i = 0; $i < $line->quantity()->toInteger(); ++$i) {
                $code = Code::with(
                    CodeId::generate(),
                    CodeOrderId::fromString($order->id()->toString()),
                    CodeOrderLineId::fromString($line->id()->toString()),
                    CodeTicketId::fromString($line->ticketId()->toString())
                );
                $codes[] = $code;
                $this->codes->add($code);
            }
        }

        $this->orders->save();
        $this->codes->save();
        $this->notifier->sentCodesTo($codes, $order->purchaser()->email()->toString());
    }
}
