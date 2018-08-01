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

use EataDevTest\Domain\Code\Exception\InvalidCodeTicketId;
use EataDevTest\Domain\ValueObject;

final class CodeTicketId implements ValueObject
{
    /** @var string */
    private $ticketId;

    public static function fromString(string $ticketId): self
    {
        return new self($ticketId);
    }

    private function __construct(string $ticketId)
    {
        if (empty($ticketId)) {
            throw InvalidCodeTicketId::causeEmptyString();
        }

        $this->ticketId = $ticketId;
    }

    public function toString(): string
    {
        return $this->ticketId;
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return get_class($this) === get_class($valueObject) && $this->toString() === $valueObject->toString();
    }
}
