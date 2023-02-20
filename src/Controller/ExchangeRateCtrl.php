<?php

declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Type;

#[Route('')]
final class ExchangeRateCtrl
{
    public function __construct(private SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[
        Get('/{currency}/{startDate}/{endDate}')
    ]
    public function findPaginatedIptvEventsAction(Request $request, ParamFetcherInterface $paramFetcher): Response
    {
        $currency = $paramFetcher->get('currency');
        $startDate = $paramFetcher->get('startDate');
        $endDate = $paramFetcher->get('endDate');
        return new Response($this->serializer->serialize('test test', 'json', ['groups' => ['sample_group']]));
    }
}
