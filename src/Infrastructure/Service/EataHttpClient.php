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

use DateInterval;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\HttpFoundation\Response;

final class EataHttpClient extends Client implements HttpClient
{
    /** @var string */
    private $apiKey;

    /** @var DateInterval */
    private $apiTokenExpiration;

    /** @var CacheItemPoolInterface */
    private $cache;

    public function __construct(
        string $apiUrl,
        string $apiVersion,
        string $apiKey,
        string $apiTokenExpiration,
        CacheItemPoolInterface $cache
    ) {
        parent::__construct([
            'base_uri' => sprintf('%s/v%s/', $apiUrl, $apiVersion),
        ]);
        $this->apiKey = $apiKey;
        $this->apiTokenExpiration = DateInterval::createFromDateString($apiTokenExpiration);
        $this->cache = $cache;
    }

    public function accessToken(): string
    {
        $accessToken = $this->cache->getItem('access_token');

        if (!$accessToken->isHit()) {
            $refreshToken = $this->cache->getItem('refresh_token');
            $response = $this->request('post', 'oauth/token', [
                'json' => [
                    'api_key' => $this->apiKey,
                ],
            ]);
            $body = json_decode($response->getBody()->getContents(), true);

            $accessToken->expiresAfter($this->apiTokenExpiration);
            $accessToken->set($body['access_token']);
            $refreshToken->set($body['refresh_token']);
            $this->cache->save($accessToken);
            $this->cache->save($refreshToken);
        }

        return $accessToken->get();
    }

    public function refreshTokens(): void
    {
        $accessToken = $this->cache->getItem('access_token');
        $refreshToken = $this->cache->getItem('refresh_token');
        $response = $this->request('post', 'oauth/refresh', [
            'json' => [
                'refresh_key' => $refreshToken->get(),
            ],
        ]);
        $body = json_decode($response->getBody()->getContents(), true);

        $accessToken->expiresAfter($this->apiTokenExpiration);
        $accessToken->set($body['access_token']);
        $refreshToken->set($body['refresh_token']);
        $this->cache->save($accessToken);
        $this->cache->save($refreshToken);
    }

    public function get(string $uri): Response
    {
        try {
            $accessToken = $this->accessToken();
            $response = $this->request('get', $uri, [
                'query' => [
                    'access_token' => $accessToken,
                ],
            ]);

            return Response::create($response->getBody(), $response->getStatusCode(), $response->getHeaders());
        } catch (ClientException $exception) {
            $response = $exception->getResponse();

            switch ($exception->getResponse()->getStatusCode()) {
                case 401:
                    $this->refreshTokens();

                    return $this->get($uri);
                default:
                    return Response::create($response->getBody(), $response->getStatusCode(), $response->getHeaders());
            }
        }
    }

    public function post(string $uri, array $body = []): Response
    {
        $accessToken = $this->accessToken();

        try {
            $response = $this->request('post', $uri, [
                'query' => [
                    'access_token' => $accessToken,
                ],
                'json' => $body,
            ]);

            return Response::create($response->getBody(), $response->getStatusCode(), $response->getHeaders());
        } catch (ClientException $exception) {
            $response = $exception->getResponse();

            switch ($response->getStatusCode()) {
                case 401:
                    $this->refreshTokens();

                    return $this->post($uri, $body);
                default:
                    return Response::create($response->getBody(), $response->getStatusCode(), $response->getHeaders());
            }
        }
    }
}
