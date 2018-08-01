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

use EataDevTest\Domain\Ticket\Exception\InvalidTicketDescription;
use EataDevTest\Domain\ValueObject;

final class TicketDescription implements ValueObject
{
    /** @var string */
    private $description;

    public static function fromString(string $description): self
    {
        return new self($description);
    }

    private function __construct(string $description)
    {
        if (empty($description)) {
            throw InvalidTicketDescription::causeEmptyString();
        }

        $this->description = $description;
    }

    public function toString(): string
    {
        return $this->description;
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return get_class($this) === get_class($valueObject) && $this->toString() === $valueObject->toString();
    }
}
