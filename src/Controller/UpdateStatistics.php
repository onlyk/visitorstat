<?php
declare(strict_types=1);

namespace App\Controller;


use App\Handler\UpdateVisitorStatisticsHandler;
use Predis\ClientException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UpdateStatistics extends AbstractController
{
    public function __construct(
        private UpdateVisitorStatisticsHandler $updateVisitorStatisticsHandler,
        private LoggerInterface $logger,
        private ValidatorInterface $validator
    ) {}

    #[Route(path: '/statistics', name: 'statistics_update', methods: "POST")]
    public function __invoke(Request $request): JsonResponse
    {
        $this->logger->info(json_encode($request));
        $country = $request->get('country');
        /** @TODO затащить резолвер requestObject-ов и выкинуть туда валидацию */
        $errors = $this->validator->validate(
            $country,
            [
                new Assert\NotBlank(),
                new Assert\Type('string')
            ]
        );
        if ($errors->count()) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->updateVisitorStatisticsHandler->increaseVisitorStatistics($country);
        } catch (ClientException $clientException) {
            $this->logger->error(json_encode(['request' => $request, 'exception' => $clientException->getMessage()]));

            return $this->json($clientException->getMessage(),Response::HTTP_BAD_REQUEST);
        }

        return $this->json('', Response::HTTP_OK);
    }
}