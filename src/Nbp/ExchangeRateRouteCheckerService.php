<?php

declare(strict_types=1);

namespace App\Nbp;

use Symfony\Bundle\FrameworkBundle\Routing\Attribute\AsRoutingConditionService;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsRoutingConditionService(alias: 'exchange_rate_route_checker')]
class ExchangeRateRouteCheckerService
{
    public function __construct(private ContainerBagInterface $params)
    {
    }

    public function checkDates(array $params): bool
    {
        $timeStartDate = strtotime($params['startDate']);
        $timeEndDate = strtotime($params['endDate']);
        $diffDays = round(($timeEndDate - $timeStartDate) / (60 * 60 * 24));
        if ($timeEndDate < $timeStartDate) {
            throw new BadRequestHttpException('Request params invalid: endDate must be higher than startDate');
        }
        if ($timeStartDate < strtotime($this->params->get('app.nbp_min_date'))) {
            throw new BadRequestHttpException(
                'Request params invalid: startDate must be equal or higher than ' .
                    $this->params->get('app.nbp_min_date')
            );
        }
        if ($diffDays > $this->params->get('app.nbp_max_days')) {
            throw new BadRequestHttpException(
                'Request params invalid: days span must be lower or equal to ' . $this->params->get('app.nbp_max_days')
            );
        }
        return true;
    }
}
