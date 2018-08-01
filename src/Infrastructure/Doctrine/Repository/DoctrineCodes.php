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

namespace EataDevTest\Infrastructure\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use EataDevTest\Application\Exception\NotFoundCode;
use EataDevTest\Application\Repository\Codes;
use EataDevTest\Domain\Code\Model\Code;
use EataDevTest\Domain\Code\Model\CodeId;

final class DoctrineCodes extends ServiceEntityRepository implements Codes
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Code::class);
    }

    public function add(Code $code): void
    {
        $this->_em->persist($code);
    }

    public function withId(CodeId $id): Code
    {
        $code = $this->findOneBy(['id' => $id]);

        if (!$code instanceof Code) {
            throw NotFoundCode::withId($id->toString());
        }

        return $code;
    }

    public function update(Code $code): void
    {
        $this->_em->merge($code);
    }

    public function save(): void
    {
        $this->_em->flush();
    }
}
