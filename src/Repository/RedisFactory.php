<?php
declare(strict_types=1);

namespace App\Repository;


use Predis\Client;

/** @TODO заменить на нативный phpredis */
final class RedisFactory
{
    public static function create(
        string $scheme,
        string $host,
        string $port
    ): Client
    {
        return new Client([
            'scheme' => $scheme,
            'host'   => $host,
            'port'   => $port,
        ]);
    }
}