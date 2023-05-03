<?php
declare(strict_types=1);

namespace App\Controller;

use App\Handler\GetVisitorStatictisHandler;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetStatistics extends AbstractController
{
    public function __construct(
        private GetVisitorStatictisHandler $getVisitorStatictisHandler,
        private LoggerInterface $logger
    ) {}

    #[Route(path: '/statistics/get', name: 'get_statistics', methods: "GET", )]
    public function __invoke(Request $request): JsonResponse
    {
        $this->logger->info($request);

        try {
            $visitorStatistics = $this->getVisitorStatictisHandler->getVisitorStatistics();
        } catch (ClientException $clientException) {
            return $this->json($clientException->getMessage(), Response::HTTP_OK);
        }

        return $this->json($visitorStatistics->statistics, Response::HTTP_OK);
    }
}