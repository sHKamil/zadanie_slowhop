<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpFile 
{

    public function __construct(private HttpClientInterface $httpClient) {

    }

    public function saveFile(string $url, string $savePath) {
        $response = $this->httpClient->request('GET', $url);
        $fileHandler = fopen($savePath, 'w');
        fwrite($fileHandler, $response->getContent());

        return $response->getStatusCode();
    }
}
