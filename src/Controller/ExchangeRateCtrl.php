<?php

declare(strict_types=1);

namespace App\Controller;

use App\Nbp\NbpApiDataModel;
use App\Nbp\NbpApiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('')]
final class ExchangeRateCtrl extends AbstractController
{
    public function __construct(private SerializerInterface $serializer, private NbpApiService $nbpApiService)
    {
    }

    #[
        Route(
            '/{currency}/{startDate}/{endDate}',
            name: 'average_exchange_rate',
            requirements: [
                'currency' => 'USD|EUR|CHF|GBP',
                'startDate' => Requirement::DATE_YMD,
                'endDate' => Requirement::DATE_YMD,
            ]
        )
    ]
    public function getAverageExchangeRateAction(
        Request $request,
        string $currency,
        string $startDate,
        string $endDate
    ): Response {
        return new Response(
            $this->serializer->serialize($this->nbpApiService->getNbpApiData($currency, $startDate, $endDate), 'json', [
                'groups' => NbpApiDataModel::GROUP_AVERAGE,
            ])
        );
    }
}
