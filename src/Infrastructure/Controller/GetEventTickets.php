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

namespace EataDevTest\Infrastructure\Controller;

use EataDevTest\Application\Repository\Tickets;
use EataDevTest\Domain\Ticket\Model\Ticket;
use Symfony\Component\HttpFoundation\Response;

final class GetEventTickets
{
    /** @var Tickets */
    private $tickets;

    public function __construct(Tickets $tickets)
    {
        $this->tickets = $tickets;
    }

    public function __invoke(string $id): Response
    {
        $tickets = array_map(function (Ticket $ticket) {
            return $ticket->toArray();
        }, $this->tickets->withEventId($id));

        return Response::create(json_encode($tickets), 200);
    }
}
