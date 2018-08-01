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

use EataDevTest\Domain\Event\Exception\InvalidEventId;
use EataDevTest\Domain\ValueObject;

final class EventId implements ValueObject
{
    /** @var string */
    private $id;

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    private function __construct(string $id)
    {
        if (empty($id)) {
            throw InvalidEventId::causeEmptyString();
        }

        $this->id = $id;
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return get_class($this) === get_class($valueObject) && $this->toString() === $valueObject->toString();
    }
}
