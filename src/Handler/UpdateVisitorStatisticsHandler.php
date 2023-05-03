<?php
declare(strict_types=1);

namespace App\Handler;


use App\Repository\VisitorStatisticsRepository;
use Predis\ClientException;
use Psr\Log\LoggerInterface;

final class UpdateVisitorStatisticsHandler
{
    public function __construct(
        private VisitorStatisticsRepository $visitorStatisticsRepository,
        private LoggerInterface $logger
    ) {}

    /** @throw ClientException */
    public function increaseVisitorStatistics(string $country): void
    {
        try {
            $this->visitorStatisticsRepository->increase($country);
        } catch (ClientException $clientException) {
            $this->logger->error(json_encode(['country' => $country, 'exception' =>$clientException->getMessage()]));
            throw $clientException;
        }
    }
}