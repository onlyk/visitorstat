<?php
declare(strict_types=1);

namespace App\Repository;


use App\Handler\Components\VisitorStatistics;
use Predis\Client;
use Predis\ClientException;

final class VisitorStatisticsRepository
{
    public function __construct(
        private Client $redis
    ) {}

    /** @throw ClientException */
    public function increase($country): void
    {
        $this->redis->incr($country);
    }

    /** @throw ClientException */
    public function getVisitorStatistics(): VisitorStatistics
    {
        /** @TODO заменить на scan, чтобы меньше отжирало ram */
        $keys = $this->redis->keys('*');
        $visitorStatisticsArray = [];
        foreach ($keys as $key) {
            $visitorStatisticsArray[$key] = (int)$this->redis->get($key);
        }

        return new VisitorStatistics($visitorStatisticsArray);
    }
}