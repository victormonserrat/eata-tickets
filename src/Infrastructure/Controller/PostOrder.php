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

use EataDevTest\Application\Command\AddOrder;
use EataDevTest\Domain\Order\Model\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Messenger\MessageBusInterface;

final class PostOrder
{
    /** @var MessageBusInterface */
    private $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function __invoke(Request $request): Response
    {
        $body = json_decode($request->getContent(), true);

        if (!is_array($body)) {
            throw new BadRequestHttpException('Syntax error');
        }

        $this->bus->dispatch(AddOrder::with(Order::fromArray($body)));

        return Response::create($request->getContent(), 201);
    }
}
