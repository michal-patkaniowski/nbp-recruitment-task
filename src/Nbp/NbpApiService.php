<?php

declare(strict_types=1);

namespace App\Nbp;

use ErrorException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class NbpApiService
{
    public function __construct(private SerializerInterface $serializer, private ContainerBagInterface $params)
    {
    }

    public function getNbpApiData(string $currency, string $startDate, string $endDate): NbpApiDataModel
    {
        $headers = ['Accept: application/json'];
        $url = sprintf('%s%s/%s/%s', $this->params->get('app.nbp_api_url'), $currency, $startDate, $endDate);
        $a = $this->sendRequest($url, $headers);
        return $this->serializer->deserialize($this->sendRequest($url, $headers), NbpApiDataModel::class, 'json');
    }

    private function sendRequest(string $url, array $headers = []): bool|string
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($httpcode === 404) {
            throw new NotFoundHttpException($response);
        } elseif ($httpcode === 400) {
            throw new BadRequestHttpException($response);
        } elseif ($httpcode !== 200) {
            throw new HttpException($httpcode, $response);
        }

        curl_close($curl);

        return $response;
    }
}
