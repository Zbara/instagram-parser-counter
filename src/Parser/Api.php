<?php

namespace App\Parser;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Api
{
    private HttpClientInterface $httpClient;

    public function __construct(
        HttpClientInterface    $httpClient,
    )
    {
        $this->httpClient = $httpClient;
    }

    public function request(string $login): array|bool
    {
        try {
            $response = $this->httpClient->request('GET', 'https://i.instagram.com/api/v1/users/web_profile_info/?username=' . $login, [
                'headers' => [
                    'X-IG-App-ID' =>  '936619743392459'
                ],
                'proxy' => 'http://:@127.0.0.1:8888'
            ]);
            if (Response::HTTP_OK === $response->getStatusCode()) {
                return $response->toArray();
            }
        } catch (DecodingExceptionInterface|TransportExceptionInterface|ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            return false;
        }
        return false;
    }
}

