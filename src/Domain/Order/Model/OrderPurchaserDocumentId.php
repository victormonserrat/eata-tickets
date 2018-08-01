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

use EataDevTest\Domain\Order\Exception\InvalidOrderPurchaserDocumentId;
use EataDevTest\Domain\ValueObject;

final class OrderPurchaserDocumentId implements ValueObject
{
    /** @var string */
    private $documentId;

    public static function fromString(string $documentId): self
    {
        return new self($documentId);
    }

    private function __construct(string $documentId)
    {
        if (empty($documentId)) {
            throw InvalidOrderPurchaserDocumentId::causeEmptyString();
        }

        $this->documentId = $documentId;
    }

    public function toString(): string
    {
        return $this->documentId;
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return get_class($this) === get_class($valueObject) && $this->toString() === $valueObject->toString();
    }
}
