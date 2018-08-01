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

namespace EataDevTest\Domain\Ticket\Model;

use EataDevTest\Domain\Entity;
use EataDevTest\Domain\Event\Exception\InvalidTicket;

final class Ticket implements Entity
{
    /** @var TicketId */
    private $id;

    /** @var TicketName */
    private $name;

    /** @var TicketDescription */
    private $description;

    /** @var TicketPrice */
    private $price;

    public static function fromArray(array $ticket): self
    {
        if (!array_key_exists('id', $ticket)) {
            throw InvalidTicket::causeUndefinedAttribute('Id');
        }
        if (!is_string($ticket['id'])) {
            throw InvalidTicket::causeUnexpectedAttributeType('Id', 'string');
        }
        if (!array_key_exists('name', $ticket)) {
            throw InvalidTicket::causeUndefinedAttribute('Name');
        }
        if (!is_string($ticket['name'])) {
            throw InvalidTicket::causeUnexpectedAttributeType('Name', 'string');
        }
        if (!array_key_exists('description', $ticket)) {
            throw InvalidTicket::causeUndefinedAttribute('Description');
        }
        if (!is_string($ticket['description'])) {
            throw InvalidTicket::causeUnexpectedAttributeType('Description', 'string');
        }
        if (!array_key_exists('price', $ticket)) {
            throw InvalidTicket::causeUndefinedAttribute('Price');
        }
        if (!is_int($ticket['price'])) {
            throw InvalidTicket::causeUnexpectedAttributeType('Price', 'integer');
        }

        return new self(
            TicketId::fromString($ticket['id']),
            TicketName::fromString($ticket['name']),
            TicketDescription::fromString($ticket['description']),
            TicketPrice::fromInteger($ticket['price'])
        );
    }

    public static function with(
        TicketId $id,
        TicketName $name,
        TicketDescription $description,
        TicketPrice $price
    ): self {
        return new self($id, $name, $description, $price);
    }

    private function __construct(TicketId $id, TicketName $name, TicketDescription $description, TicketPrice $price)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->toString(),
            'name' => $this->name()->toString(),
            'description' => $this->description()->toString(),
            'price' => $this->price()->toInteger(),
        ];
    }

    public function getId(): string
    {
        return $this->id()->toString();
    }

    public function id(): TicketId
    {
        return $this->id;
    }

    public function name(): TicketName
    {
        return $this->name;
    }

    public function description(): TicketDescription
    {
        return $this->description;
    }

    public function price(): TicketPrice
    {
        return $this->price;
    }

    public function hasSameIdentityAs(Entity $entity): bool
    {
        /** @var self $entity */
        return get_class($this) === get_class($entity) && $this->id()->toString() === $this->id()->toString();
    }
}
