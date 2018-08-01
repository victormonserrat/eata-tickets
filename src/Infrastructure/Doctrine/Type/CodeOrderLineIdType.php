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

namespace EataDevTest\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use EataDevTest\Domain\Code\Model\CodeOrderLineId;

final class CodeOrderLineIdType extends Type
{
    private const NAME = 'code_order_line_id';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    /** @param CodeOrderLineId $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->toString();
    }

    /** @param string $value */
    public function convertToPHPValue($value, AbstractPlatform $platform): CodeOrderLineId
    {
        return CodeOrderLineId::fromString($value);
    }

    public function getName(): string
    {
        return static::NAME;
    }
}
