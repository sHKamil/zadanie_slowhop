<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpFile 
{

    public function __construct(private HttpClientInterface $httpClient) {

    }

    public function getFile($url) {
        $response = $this->httpClient->request('GET', $url);

        return $response->getContent();
    }

    public function saveFile($url) {
        $response = $this->httpClient->request('GET', $url);
        $fileHandler = fopen('./file.ics', 'w');
        fwrite($fileHandler, $response->getContent());
        
        return $response->getStatusCode();
    }
}
