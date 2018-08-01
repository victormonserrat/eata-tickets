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

namespace EataDevTest\Domain\Event\Model;

use EataDevTest\Domain\Entity;
use EataDevTest\Domain\Order\Exception\InvalidOrder;

final class Event implements Entity
{
    /** @var EventId */
    private $id;

    /** @var EventName */
    private $name;

    /** @var EventDate */
    private $date;

    public static function fromArray(array $event): self
    {
        if (!array_key_exists('id', $event)) {
            throw InvalidOrder::causeUndefinedAttribute('Id');
        }
        if (!is_string($event['id'])) {
            throw InvalidOrder::causeUnexpectedAttributeType('Id', 'string');
        }
        if (!array_key_exists('name', $event)) {
            throw InvalidOrder::causeUndefinedAttribute('Name');
        }
        if (!is_string($event['name'])) {
            throw InvalidOrder::causeUnexpectedAttributeType('Name', 'string');
        }
        if (!array_key_exists('date', $event)) {
            throw InvalidOrder::causeUndefinedAttribute('Date');
        }
        if (!is_string($event['date'])) {
            throw InvalidOrder::causeUnexpectedAttributeType('Date', 'string');
        }

        return new self(
            EventId::fromString($event['id']),
            EventName::fromString($event['name']),
            EventDate::fromString($event['description'])
        );
    }

    public static function with(EventId $id, EventName $name, EventDate $date): self
    {
        return new self($id, $name, $date);
    }

    private function __construct(EventId $id, EventName $name, EventDate $date)
    {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->toString(),
            'name' => $this->name()->toString(),
            'date' => $this->date()->toString(),
        ];
    }

    public function getId(): string
    {
        return $this->id()->toString();
    }

    public function id(): EventId
    {
        return $this->id;
    }

    public function name(): EventName
    {
        return $this->name;
    }

    public function date(): EventDate
    {
        return $this->date;
    }

    public function hasSameIdentityAs(Entity $entity): bool
    {
        /** @var self $entity */
        return get_class($this) === get_class($entity) && $this->id()->toString() === $this->id()->toString();
    }
}
