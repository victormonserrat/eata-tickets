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

use EataDevTest\Application\Repository\Events;
use EataDevTest\Domain\Event\Model\Event;
use Symfony\Component\HttpFoundation\Response;

final class GetEvents
{
    /** @var Events */
    private $events;

    public function __construct(Events $events)
    {
        $this->events = $events;
    }

    public function __invoke(): Response
    {
        $events = array_map(function (Event $event) {
            return $event->toArray();
        }, $this->events->all());

        return Response::create(json_encode($events), 200);
    }
}
