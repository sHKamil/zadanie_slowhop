<?php

namespace App\Service;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;

class UploaderAWS 
{
    private $key;
    private $secret;
    private $bucket;
    private $region;


    public function __construct(
        $bucket = 'zadanie-slowhop',
        $region = 'eu-north-1'
    ) {
        $this->bucket = $bucket;
        $this->region = $region;
        $this->key = $_ENV['AWS_ACCESS_KEY_ID'];
        $this->secret = $_ENV['AWS_SECRET_ACCESS_KEY'];
    }

    public function uploadFile($body, string $fileNamePrefix, string $contentType = 'application/json', $ACL = 'public-read') {

        if($_ENV['AWS_SECRET_ACCESS_KEY'] === 'PASTE_SECRET_KEY_HERE' || $_ENV['AWS_SECRET_ACCESS_KEY'] === "") return; //

        $s3Client = new S3Client([
            'region' => $this->region,
            'version' => 'latest',
            'credentials' => [
                'key'    => $this->key,
                'secret' => $this->secret,
            ],
        ]);

        $fileName = $fileNamePrefix . '.json';
        $link = "";
        try {
            $result = $s3Client->putObject([
                'Bucket' => $this->bucket,
                'Key' => $fileName,
                'Body' => $body,
                'ContentType' => $contentType,
                'ACL' => $ACL,
            ]);
            $link = $result["ObjectURL"];
        } catch (AwsException $e) {
            echo $e->getMessage();
        }

        return $link;
    }
}
