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

use EataDevTest\Application\Exception\NotFoundEvent;
use EataDevTest\Application\Repository\Tickets;
use EataDevTest\Domain\Ticket\Model\Ticket;
use EataDevTest\Domain\Ticket\Model\TicketDescription;
use EataDevTest\Domain\Ticket\Model\TicketId;
use EataDevTest\Domain\Ticket\Model\TicketName;
use EataDevTest\Domain\Ticket\Model\TicketPrice;
use EataDevTest\Infrastructure\Service\HttpClient;

final class RestTickets implements Tickets
{
    /** @var HttpClient */
    private $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /** @return Ticket[] */
    public function withEventId(string $eventId)
    {
        $response = $this->client->get(sprintf('events/%s/tickets', $eventId));
        $body = json_decode($response->getContent(), true);

        if (array_key_exists('error', $body) && $body['error']['code'] === 404) {
            throw NotFoundEvent::withId($eventId);
        }

        return array_map(function (array $ticket) {
            return Ticket::with(
                TicketId::fromString((string) $ticket['id']),
                TicketName::fromString($ticket['name']),
                TicketDescription::fromString($ticket['description']),
                TicketPrice::fromInteger($ticket['price'] * 100)
            );
        }, $body);
    }

    public function save(): void
    {
    }
}
