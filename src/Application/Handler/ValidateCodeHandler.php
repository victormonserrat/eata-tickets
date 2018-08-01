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

namespace EataDevTest\Application\Handler;

use EataDevTest\Application\Command\ValidateCode;
use EataDevTest\Application\Exception\NotValidatedCode;
use EataDevTest\Application\Repository\Codes;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ValidateCodeHandler implements MessageHandlerInterface
{
    /** @var Codes */
    private $codes;

    public function __construct(Codes $codes)
    {
        $this->codes = $codes;
    }

    public function __invoke(ValidateCode $command): void
    {
        $code = $command->code();

        if ($code->isValidated()) {
            throw NotValidatedCode::causeValidatedAt($code->validationDate()->toString(), $code->orderId()->toString());
        }

        $code->validate();
        $this->codes->update($code);
        $this->codes->save();
    }
}
