<?php

namespace App\Tests\Service;

use App\Service\HttpFile;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class HttpFileTest extends TestCase
{
    public function testDownloadAndSaveFileFromUrl()
    {
        $fileContent = 'File content: ' . bin2hex(random_bytes(8));
        $httpClient = new MockHttpClient([
            new MockResponse($fileContent, ['http_headers' => ['content-type' => 'text/calendar; charset=UTF-8']]),
        ]);

        $httpFile = new HttpFile($httpClient);
        $url = 'https://slowhop.com/icalendar-export/api-v1/21c0ed902d012461d28605cdb2a8b7a2.ics';
        $savePath = './public/calendar/file.ics';
        $httpFile->saveFile($url, $savePath);

        $this->assertFileExists($savePath);
        $this->assertStringEqualsFile($savePath, $fileContent);
    }
}
