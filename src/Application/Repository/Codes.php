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

namespace EataDevTest\Application\Repository;

use EataDevTest\Domain\Code\Model\Code;
use EataDevTest\Domain\Code\Model\CodeId;

interface Codes
{
    public function add(Code $code): void;

    public function withId(CodeId $id): Code;

    public function update(Code $code): void;

    public function save(): void;
}
