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

use EataDevTest\Application\Repository\Events;
use EataDevTest\Domain\Event\Model\Event;
use EataDevTest\Domain\Event\Model\EventDate;
use EataDevTest\Domain\Event\Model\EventId;
use EataDevTest\Domain\Event\Model\EventName;
use EataDevTest\Infrastructure\Service\HttpClient;

final class RestEvents implements Events
{
    /** @var HttpClient */
    private $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /** @return Event[] */
    public function all()
    {
        $response = $this->client->get('events');
        $body = json_decode($response->getContent(), true);

        return array_map(function (array $event) {
            return Event::with(
                EventId::fromString((string) $event['id']),
                EventName::fromString($event['name']),
                EventDate::fromString($event['date'])
            );
        }, $body);
    }

    public function save(): void
    {
    }
}
