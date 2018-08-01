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

use EataDevTest\Domain\Ticket\Exception\InvalidTicketName;
use EataDevTest\Domain\ValueObject;

final class TicketName implements ValueObject
{
    /** @var string */
    private $name;

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    private function __construct(string $name)
    {
        if (empty($name)) {
            throw InvalidTicketName::causeEmptyString();
        }

        $this->name = $name;
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return get_class($this) === get_class($valueObject) && $this->toString() === $valueObject->toString();
    }
}
