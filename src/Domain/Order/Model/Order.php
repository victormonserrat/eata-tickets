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

use EataDevTest\Domain\Entity;
use EataDevTest\Domain\Order\Exception\InvalidOrder;

final class Order implements Entity
{
    /** @var OrderId */
    private $id;

    /** @var OrderPurchaser */
    private $purchaser;

    /** @var OrderLine[] */
    private $lines;

    public static function fromArray(array $order): self
    {
        if (!array_key_exists('purchaser', $order)) {
            throw InvalidOrder::causeUndefinedAttribute('Purchaser');
        }
        if (!is_array($order['purchaser'])) {
            throw InvalidOrder::causeUnexpectedAttributeType('Purchaser', 'object');
        }
        if (!array_key_exists('lines', $order)) {
            throw InvalidOrder::causeUndefinedAttribute('Lines');
        }
        if (!is_array($order['lines'])) {
            throw InvalidOrder::causeUnexpectedAttributeType('Lines', 'array');
        }

        return new self(
            array_key_exists('id', $order) ? OrderId::fromString($order['id']) : OrderId::generate(),
            OrderPurchaser::fromArray($order['purchaser']),
            array_map(function ($line, $index) {
                if (!is_array($line)) {
                    throw InvalidOrder::causeUnexpectedAttributeType(
                        sprintf('Line %d', $index + 1),
                        'object'
                    );
                }

                return OrderLine::fromArray($line);
            }, $order['lines'], array_keys($order['lines']))
        );
    }

    /** @param OrderLine[] $lines */
    public static function with(OrderId $id, OrderPurchaser $purchaser, array $lines): self
    {
        return new self($id, $purchaser, $lines);
    }

    /** @param OrderLine[] $lines */
    private function __construct(OrderId $id, OrderPurchaser $purchaser, array $lines)
    {
        if (count($lines) < 1) {
            throw InvalidOrder::causeEmptyAttribute('Lines');
        }

        $this->id = $id;
        $this->purchaser = $purchaser;
        $this->lines = $lines;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->toString(),
            'purchaser' => $this->purchaser()->toArray(),
            'lines' => array_map(function (OrderLine $line) {
                return $line->toArray();
            }, $this->lines()),
        ];
    }

    public function getId(): string
    {
        return $this->id()->toString();
    }

    public function id(): OrderId
    {
        return $this->id;
    }

    public function purchaser(): OrderPurchaser
    {
        return $this->purchaser;
    }

    /** @return OrderLine[] */
    public function lines(): array
    {
        return $this->lines;
    }

    public function hasSameIdentityAs(Entity $entity): bool
    {
        /** @var self $entity */
        return get_class($this) === get_class($entity) && $this->id()->toString() === $this->id()->toString();
    }
}
