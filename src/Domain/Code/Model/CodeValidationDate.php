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

use DateTime;
use EataDevTest\Domain\ValueObject;

final class CodeValidationDate implements ValueObject
{
    /** @var DateTime */
    private $date;

    public static function fromNow()
    {
        return new self(new DateTime());
    }

    public static function fromString(string $date)
    {
        return new self(DateTime::createFromFormat(DateTime::ATOM, $date));
    }

    private function __construct(DateTime $date)
    {
        $this->date = $date;
    }

    public function toString(): string
    {
        return $this->date->format(DateTime::ATOM);
    }

    public function hasSameValueAs(ValueObject $valueObject): bool
    {
        /** @var self $valueObject */
        return get_class($this) === get_class($valueObject) && $this->toString() === $valueObject->toString();
    }
}
