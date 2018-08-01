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

namespace EataDevTest\Infrastructure\Controller;

use EataDevTest\Application\Command\ValidateCode as ValidateCodeCommand;
use EataDevTest\Application\Exception\NotFoundCode;
use EataDevTest\Application\Repository\Codes;
use EataDevTest\Domain\Code\Model\CodeId;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

final class ValidateCode
{
    /** @var MessageBusInterface */
    private $bus;

    /** @var Codes */
    private $codes;

    public function __construct(MessageBusInterface $bus, Codes $codes)
    {
        $this->bus = $bus;
        $this->codes = $codes;
    }

    public function __invoke(string $id): Response
    {
        try {
            $id = CodeId::fromString($id);
        } catch (InvalidUuidStringException $exception) {
            throw NotFoundCode::withId($id);
        }

        $code = $this->codes->withId($id);

        $this->bus->dispatch(ValidateCodeCommand::with($code));

        return Response::create(json_encode($code->toArray()), 200);
    }
}
