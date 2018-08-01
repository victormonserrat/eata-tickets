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

namespace EataDevTest\Infrastructure\Service;

use Symfony\Component\HttpFoundation\Response;

interface HttpClient
{
    public function get(string $uri): Response;

    public function post(string $uri, array $body = []): Response;
}
