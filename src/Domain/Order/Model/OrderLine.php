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

namespace EataDevTest\Domain\Order\Model;

use EataDevTest\Domain\Order\Exception\InvalidOrderLine;
use EataDevTest\Domain\ValueObject;

final class OrderLine implements ValueObject
{
    /** @var OrderLineId */
    private $id;

    /** @var OrderLineTicketId */
    private $ticketId;

    /** @var OrderLineQuantity */
    private $quantity;

    public static function fromArray(array $line): self
    {
        if (!array_key_exists('ticketId', $line)) {
            throw InvalidOrderLine::causeUndefinedAttribute('Line ticket id');
        }
        if (!is_string($line['ticketId'])) {
            throw InvalidOrderLine::causeUnexpectedAttributeType('Line ticket id', 'string');
        }
        if (!array_key_exists('quantity', $line)) {
            throw InvalidOrderLine::causeUndefinedAttribute('Line quantity');
        }
        if (!is_int($line['quantity'])) {
            throw InvalidOrderLine::causeUnexpectedAttributeType('Line quantity', 'integer');
        }

        return new self(
            array_key_exists('id', $line) ? OrderLineId::fromString($line['id']) : OrderLineId::generate(),
            OrderLineTicketId::fromString($line['ticketId']),
            OrderLineQuantity::fromInteger($line['quantity'])
        );
    }

    public static function with(OrderLineId $id, OrderLineTicketId $ticketId, OrderLineQuantity $quantity): self
    {
        return new self($id, $ticketId, $quantity);
    }

    private function __construct(OrderLineId $id, OrderLineTicketId $ticketId, OrderLineQuantity $quantity)
    {
        $this->id = $id;
        $this->ticketId = $ticketId;
        $this->quantity = $quantity;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'ticketId' => $this->ticketId()->toString(),
            'quantity' => $this->quantity()->toInteger(),
        ];
    }

    public function id(): OrderLineId
    {
        return $this->id;
    }

    public function ticketId(): OrderLineTicketId
    {
        return $this->ticketId;
    }

    public function quantity(): OrderLineQuantity
    {
        return $this->quantity;
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return
            get_class($this) === get_class($valueObject) &&
            $this->ticketId()->hasSameValueAs($valueObject->ticketId()) &&
            $this->quantity()->hasSameValueAs($valueObject->quantity())
        ;
    }
}
