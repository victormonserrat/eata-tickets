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

namespace EataDevTest\Infrastructure\Repository;

use EataDevTest\Application\Exception\NotFoundTicket;
use EataDevTest\Application\Repository\Orders;
use EataDevTest\Domain\Order\Model\Order;
use EataDevTest\Domain\Order\Model\OrderId;
use EataDevTest\Domain\Order\Model\OrderLine;
use EataDevTest\Domain\Order\Model\OrderLineId;
use EataDevTest\Infrastructure\Service\HttpClient;

final class RestOrders implements Orders
{
    /** @var HttpClient */
    private $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function add(Order $order): Order
    {
        $purchaser = $order->purchaser();
        $lines = $order->lines();
        $response = $this->client->post('orders', [
            'order' => [
                'documentId' => $purchaser->documentId()->toString(),
                'name' => $purchaser->name()->toString(),
                'lastname' => $purchaser->lastName()->toString(),
                'zipcode' => $purchaser->zipCode()->toString(),
                'lines' => array_map(function (OrderLine $line) {
                    return [
                        'ticket' => (int) $line->ticketId()->toString(),
                        'quantity' => $line->quantity()->toInteger(),
                    ];
                }, $lines),
            ],
        ]);
        $body = json_decode($response->getContent(), true);

        if (400 === $response->getStatusCode()) {
            $errorLines = $body['errors']['children']['lines']['children'];

            foreach ($errorLines as $index => $line) {
                if ($line['children']['ticket']['errors']) {
                    throw NotFoundTicket::withId($lines[$index]->ticketId()->toString());
                }

                $lines[$index] = OrderLine::with(
                    OrderLineId::fromString($body['lines'][$index]['uuid']),
                    $lines[$index]->ticketId(),
                    $lines[$index]->quantity()
                );
            }
        }

        return Order::with(
            OrderId::fromString($body['uuid']),
            $order->purchaser(),
            $lines
        );
    }

    public function save(): void
    {
    }
}
