<?php

namespace Drupal\offres_prestataires\Helper;

use Drupal\Component\Serialization\Json;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

class Request
{
//    const API_KEY = "99803e9a45b0430ba683c75fa9827ae4"; //prod
    const API_KEY = "7de8991be6044c7abaa3b4f78a8b32c2"; //test scoptalent api

    const API_URL = "https://api.scoptalent.com";

    const REQ_DETAIL_OFFER = "/api/public/vacancies/";
    const REQ_LIST_OFFERS = "/api/public/vacancies";
    const REQ_APPLY = "/api/public/applications/";
    const REQ_FILE_UPLOAD = "/api/public/documents/";

    public function getVacanciesList(array $params = [])
    {
        $url = self::API_URL.self::REQ_LIST_OFFERS;
        if (!empty($params)) $url .= $this->formatReqParams($params);

        return $this->getReq($url);
    }

    public function getVacancyDetails($id)
    {
        $url = self::API_URL.self::REQ_DETAIL_OFFER.$id;

        return $this->getReq($url);
    }

    public function vacancyApply($data)
    {
        $encodeData = Json::encode($data);
        $url = self::API_URL.self::REQ_APPLY;
        $config['body'] = $encodeData;
        $config['headers']['Content-Length'] = strlen($encodeData);

        return $this->postReq($url, $config);
    }

    public function postDocument($filePath)
    {
        $pathToFile = \Drupal::service('file_system')->realpath($filePath);
        if (file_exists($pathToFile)) {
            $url = self::API_URL . self::REQ_FILE_UPLOAD;

            $ch = curl_init();

            $cfile = new \CURLFile($pathToFile,'application/pdf', 'lm-test');

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: ApiKey '.self::API_KEY]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [$cfile]);

            $resp = curl_exec($ch);
            $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $responseBody = Json::decode($resp);
                return $responseBody;
            }
        }
    }

    private function getReq($url, array $config = [])
    {
        $client = \Drupal::httpClient();
        $config = $this->addBaseConfig($config);
        try {
            $response = $client->get($url, $config);

            if ($response->getStatusCode() == 200) {
                $responseBody = Json::decode($response->getBody()->getContents());
                return $responseBody;
            }
        } catch (\HttpRequestExceptioneption $e) {
            watchdog_exception('offres_prestataires', $e);
        }
    }

    private function postReq($url, array $config = [])
    {
        $client = \Drupal::httpClient();
        $config = $this->addBaseConfig($config);
        try {
            $response = $client->post($url, $config);

            if ($response->getStatusCode() == 200) {
                $responseBody = Json::decode($response->getBody()->getContents());
                return $responseBody;
            }
        } catch (\HttpRequestExceptioneption $e) {
            watchdog_exception('offres_prestataires', $e);
        }
    }

    private function formatReqParams(array $params)
    {
        if (!empty($params)) {
            foreach ($params as $paramKey => $paramValue) {
                $paramsFormat[] = $paramKey."=".$paramValue;
            }
            if (isset($paramsFormat) && !empty($paramsFormat)) {
                return "?" . implode('&', $paramsFormat);
            }
        }
    }

    private function addBaseConfig($config)
    {
        $config['headers']['Authorization'] = 'ApiKey '.self::API_KEY;
        if (!isset($config['headers']['Content-Type'])) $config['headers']['Content-Type'] = "application/json";
        return $config;
    }
}