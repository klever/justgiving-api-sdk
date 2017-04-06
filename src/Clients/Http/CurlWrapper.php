<?php

namespace Klever\JustGivingApiSdk\Clients\Http;

class CurlWrapper
{
    protected $baseUrl;
    protected $username;
    protected $password;

    public function __construct($baseUrl, $username, $password)
    {
        $this->baseUrl = $baseUrl;
        $this->username = $username;
        $this->password = $password;

        if ( ! function_exists('curl_init')) {
            die('CURL is not installed!');
        }
    }

    public function GetV2($url)
    {
        $url = $this->constructUrl($url);
        $ch = curl_init();
        $httpResponse = new HTTPRawResponse();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $this->SetCredentials($ch);

        $buffer = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $httpResponse->httpInfo = $info;
        $httpResponse->bodyResponse = $buffer;
        $httpResponse->httpStatusCode = $info['http_code'];

        return $httpResponse;
    }

    public function Get($url)
    {
        $url = $this->constructUrl($url);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $this->SetCredentials($ch);

        $buffer = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
var_dump($buffer);die();
        return $buffer;
    }

    public function PutV2($url, $payload)
    {
        $url = $this->constructUrl($url);
        $httpResponse = new HTTPRawResponse();
        $fh = fopen('php://temp', 'r+');
        fwrite($fh, $payload);
        rewind($fh);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_INFILE, $fh);
        curl_setopt($ch, CURLOPT_INFILESIZE, strlen($payload));

        $this->SetCredentials($ch);

        $buffer = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $httpResponse->httpInfo = $info;
        $httpResponse->bodyResponse = $buffer;
        $httpResponse->httpStatusCode = $info['http_code'];

        return $httpResponse;

    }

    public function Put($url, $payload, $getHttpStatus = false)
    {
        $url = $this->constructUrl($url);
        $fh = fopen('php://temp', 'r+');
        fwrite($fh, $payload);
        rewind($fh);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_INFILE, $fh);
        curl_setopt($ch, CURLOPT_INFILESIZE, strlen($payload));

        $this->SetCredentials($ch);

        $buffer = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        if ($getHttpStatus == 1) {
            return $info;
        } else {
            return $buffer;
        }

    }

    public function PostBinary($url, $filename, $imageContentType)
    {
        $url = $this->constructUrl($url);
        $fh = fopen($filename, 'rb');
        $imageBytes = fread($fh, filesize($filename));
        $ch = curl_init();
        $this->SetCredentials($ch, $imageContentType);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $imageBytes);
        curl_setopt($ch, CURLOPT_INFILE, $fh);
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($filename));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $buffer = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return $info;
    }

    public function HeadV2($url)
    {
        $url = $this->constructUrl($url);
        $ch = curl_init();
        $httpResponse = new HTTPRawResponse();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_NOBODY, true);

        $this->SetCredentials($ch);

        $buffer = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $httpResponse->httpInfo = $info;
        $httpResponse->bodyResponse = $buffer;
        $httpResponse->httpStatusCode = $info['http_code'];

        return $httpResponse;
    }

    public function Head($url)
    {
        $url = $this->constructUrl($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_NOBODY, true);

        $this->SetCredentials($ch);

        $buffer = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return $info;
    }

    public function Post($url, $payload, $contentType = "application/json")
    {
        $url = $this->constructUrl($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $this->SetCredentials($ch, $contentType);

        $buffer = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return $info;
    }

    public function PostV2($url, $payload, $contentType = "application/json")
    {
        $url = $this->constructUrl($url);
        $httpResponse = new HTTPRawResponse();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $this->SetCredentials($ch, $contentType);

        $buffer = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        $httpResponse->httpInfo = $info;
        $httpResponse->bodyResponse = $buffer;
        $httpResponse->httpStatusCode = $info['http_code'];

        return $httpResponse;

    }

    public function PostAndGetResponse($url, $payload, $contentType = "application/json")
    {
        $url = $this->constructUrl($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $this->SetCredentials($ch, $contentType);

        $buffer = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return $buffer;
    }

    public function Delete($url, $contentType = "application/json")
    {
        $url = $this->constructUrl($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

        $this->SetCredentials($ch, $contentType);
        $buffer = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return $info;
    }

    private function SetCredentials($ch, $contentType = "application/json")
    {
        $base64Credentials = base64_encode($this->username . ":" . $this->password);

        if ($base64Credentials != null && $base64Credentials != "") {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: ' . $contentType, 'Accept: ' . $contentType, 'Authorize: Basic ' . $base64Credentials, 'Authorization: Basic ' . $base64Credentials));
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: ' . $contentType, 'Accept: ' . $contentType));
        }
    }

    protected function constructUrl($url)
    {
        return $this->baseUrl . $url;
    }
}
