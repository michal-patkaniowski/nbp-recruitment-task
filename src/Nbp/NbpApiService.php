<?php

declare(strict_types=1);

namespace App\Nbp;

use Symfony\Component\Serializer\SerializerInterface;

class NbpApiService
{
    private const API_URL = 'http://api.nbp.pl/api/exchangerates/rates/C/';
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function getNbpApiData(string $currency, string $startDate, string $endDate): NbpApiDataModel
    {
        $headers = ['Accept: application/json'];
        $url = sprintf('%s%s/%s/%s', self::API_URL, $currency, $startDate, $endDate);

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

        curl_close($curl);

        return $response;
    }
}
