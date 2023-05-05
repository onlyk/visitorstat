<?php
declare(strict_types=1);

namespace App\Repository;


use App\Handler\Components\VisitorStatistics;
use Predis\Client;
use Predis\ClientException;

final class VisitorStatisticsRepository
{
    private const VISITOR_STATISTICS_KEY = 'stat';
    private const STATISTICS_INCREMENT = 1;

    public function __construct(
        private Client $redis
    ) {}

    /** @throw ClientException */
    public function increaseH($country): void
    {
        $this->redis->hincrby(self::VISITOR_STATISTICS_KEY, $country, self::STATISTICS_INCREMENT);
    }

    public function increase($country): void
    {
        $some = 1;
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