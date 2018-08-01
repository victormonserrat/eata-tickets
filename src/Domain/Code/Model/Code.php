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

namespace EataDevTest\Domain\Code\Model;

use EataDevTest\Domain\Code\Exception\InvalidCode;
use EataDevTest\Domain\Entity;

final class Code implements Entity
{
    /** @var CodeId */
    private $id;

    /** @var CodeOrderId */
    private $orderId;

    /** @var CodeOrderLineId */
    private $orderLineId;

    /** @var CodeTicketId */
    private $ticketId;

    /** @var CodeValidationDate */
    private $validationDate;

    public static function fromArray(array $code): self
    {
        if (!array_key_exists('id', $code)) {
            throw InvalidCode::causeUndefinedAttribute('Id');
        }
        if (!is_string($code['id'])) {
            throw InvalidCode::causeUnexpectedAttributeType('Id', 'string');
        }
        if (!array_key_exists('orderId', $code)) {
            throw InvalidCode::causeUndefinedAttribute('Order id');
        }
        if (!is_string($code['orderId'])) {
            throw InvalidCode::causeUnexpectedAttributeType('Order id', 'string');
        }
        if (!array_key_exists('orderLineId', $code)) {
            throw InvalidCode::causeUndefinedAttribute('Order line id');
        }
        if (!is_string($code['orderLineId'])) {
            throw InvalidCode::causeUnexpectedAttributeType('Order line id', 'string');
        }
        if (!array_key_exists('ticketId', $code)) {
            throw InvalidCode::causeUndefinedAttribute('Ticket id');
        }
        if (!is_string($code['ticketId'])) {
            throw InvalidCode::causeUnexpectedAttributeType('Ticket id', 'string');
        }

        return new self(
            CodeId::fromString($code['id']),
            CodeOrderId::fromString($code['orderId']),
            CodeOrderLineId::fromString($code['orderLineId']),
            CodeTicketId::fromString($code['ticketId']),
            $code['validationDate'] ? CodeValidationDate::fromString($code['validationDate']) : null
        );
    }

    public static function with(
        CodeId $id,
        CodeOrderId $orderId,
        CodeOrderLineId $orderLineId,
        CodeTicketId $ticketId,
        CodeValidationDate $validationDate = null
    ): self {
        return new self($id, $orderId, $orderLineId, $ticketId, $validationDate);
    }

    private function __construct(
        CodeId $id,
        CodeOrderId $orderId,
        CodeOrderLineId $orderLineId,
        CodeTicketId $ticketId,
        CodeValidationDate $validationDate = null
    ) {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->orderLineId = $orderLineId;
        $this->ticketId = $ticketId;
        $this->validationDate = $validationDate;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->toString(),
            'orderId' => $this->orderId()->toString(),
            'orderLineId' => $this->orderLineId()->toString(),
            'ticketId' => $this->ticketId()->toString(),
            'validationDate' => $this->validationDate() ? $this->validationDate()->toString() : null,
        ];
    }

    public function validate(): void
    {
        $this->validationDate = CodeValidationDate::fromNow();
    }

    public function getId(): string
    {
        return $this->id()->toString();
    }

    public function id(): CodeId
    {
        return $this->id;
    }

    public function orderId(): CodeOrderId
    {
        return $this->orderId;
    }

    public function orderLineId(): CodeOrderLineId
    {
        return $this->orderLineId;
    }

    public function ticketId(): CodeTicketId
    {
        return $this->ticketId;
    }

    public function validationDate(): ?CodeValidationDate
    {
        return $this->validationDate;
    }

    public function isValidated(): bool
    {
        return $this->validationDate !== null;
    }

    public function hasSameIdentityAs(Entity $entity): bool
    {
        /** @var self $entity */
        return get_class($this) === get_class($entity) && $this->id()->toString() === $this->id()->toString();
    }
}
