<?php
declare(strict_types=1);

namespace App\Handler;


use App\Handler\Components\VisitorStatistics;
use App\Repository\VisitorStatisticsRepository;

final class GetVisitorStatictisHandler
{
    public function __construct(
        private VisitorStatisticsRepository $visitorStatisticsRepository
    ) {}

    public function getVisitorStatistics(): VisitorStatistics
    {
        $visitorStatistics = $this->visitorStatisticsRepository->getVisitorStatisticsHscan();

        return $visitorStatistics;
    }
}