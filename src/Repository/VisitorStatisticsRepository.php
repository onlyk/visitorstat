<?php
declare(strict_types=1);

namespace App\Repository;


use App\Handler\Components\VisitorStatistics;
use Predis\Client;
use Predis\Collection\Iterator\HashKey;

final class VisitorStatisticsRepository
{
    private const VISITOR_STATISTICS_KEY = 'stat';
    private const STATISTICS_INCREMENT = 1;
    private const DEFAULT_MATCH = '*';
    private const DEFALUT_COUNT = 10;

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
        $this->redis->incr($country);
    }

    /** @throw ClientException */
    public function getVisitorStatisticsHscan(): VisitorStatistics
    {
        $hashKeyIterator = new HashKey(
            $this->redis,
            self::VISITOR_STATISTICS_KEY,
            self::DEFAULT_MATCH,
            self::DEFALUT_COUNT);

        $visitorStatisticsArray = [];
        foreach ($hashKeyIterator as $field => $value) {
            $visitorStatisticsArray[$field] = $value;
        }

        return new VisitorStatistics($visitorStatisticsArray);
    }
        /** @throw ClientException */
    public function getVisitorStatistics(): VisitorStatistics
    {
        $keys = $this->redis->keys('*');
        $visitorStatisticsArray = [];
        foreach ($keys as $key) {
            $visitorStatisticsArray[$key] = (int)$this->redis->get($key);
        }

        return new VisitorStatistics($visitorStatisticsArray);
    }
}