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

namespace EataDevTest\Application\Command;

use EataDevTest\Domain\Code\Model\Code;

final class ValidateCode
{
    /** @var array */
    private $content;

    public static function with(Code $code): self
    {
        return new self($code->toArray());
    }

    private function __construct(array $content)
    {
        $this->content = $content;
    }

    public function code(): Code
    {
        return Code::fromArray($this->content);
    }
}
