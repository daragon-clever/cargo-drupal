<?php

namespace Drupal\offres_prestataires\Helper;

use Drupal\Component\Serialization\Json;

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
        $url = self::API_URL.self::REQ_APPLY;
        $config['body'] = Json::encode($data);
        $config['headers'] = 'Content-Length: ' . strlen(Json::encode($data)); //todo: voir si ça va dans le header + voir content type

        return $this->postReq($url, $config);
    }

    public function postDocument($filePath)
    {
        $pathToFile = \Drupal::service('file_system')->realpath($filePath);
        if (file_exists($pathToFile)) {
            $url = self::API_URL . self::REQ_FILE_UPLOAD;
            $config['headers']['Content-Disposition'] = 'attachment; filename='.basename($pathToFile);
            $config['headers']['Content-Length'] = filesize($pathToFile);
//            $config['headers']['Content-Type'] = 'multipart/form-data';
//            $config['headers']['Content-Type'] = 'application/pdf';
//            $config['headers']['Content-Type'] = 'application/x-www-form-urlencoded';
//            $config['headers']['Content-Type'] = 'text/plain';
            $config['headers']['Content-Type'] = 'application/octet-stream';
//            $config['body'] = fopen($pathToFile, 'r');
            $config['body'] = file_get_contents($pathToFile);
//            $config['body'] = readfile($pathToFile);
//            Content-length

            return $this->postReq($url, $config);
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