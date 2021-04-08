<?php

namespace Drupal\offres_prestataires\Helper;

use Drupal\Component\Serialization\Json;

class Request
{
    const API_KEY = "99803e9a45b0430ba683c75fa9827ae4"; //prod
//    const API_KEY = "7de8991be6044c7abaa3b4f78a8b32c2"; //test scoptalent api

    const API_URL = "https://api.scoptalent.com";

    const REQ_DETAIL_OFFER = "/api/public/vacancies/";
    const REQ_LIST_OFFERS = "/api/public/vacancies";
    const REQ_CANDIDATURE = "/api/public/applications/";
    const REQ_FILE_UPLOAD = "/api/public/documents/";

    public function callReq($url, $body = null, $params = null)
    {
        $url = self::API_URL.$url;
        if (is_array($params)) $url .= $this->formatReqParams($params);

        $client = \Drupal::httpClient();
        $configApi = [
            'headers' => [
                'Authorization' => 'ApiKey '.self::API_KEY,
                'Content-Type: application/json'
            ]
        ];
        if (!is_null($body)) {
            $configApi['body'] = Json::encode($body);
            $configApi['headers'][] = 'Content-Length: ' . strlen(Json::encode($body));
        }

        try {
            $response = $client->get($url, $configApi); //todo: get et post et put diff

            if ($response->getStatusCode() == 200) {
                $jsonResponseBody = Json::decode($response->getBody()->getContents());
                return $jsonResponseBody;
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
}