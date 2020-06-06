<?php

/**
 * NBP API Client demo class
 */

namespace Demo\Nbp;

use Demo\Nbp\NbpApiResultJson;
use Demo\Nbp\NbpApiResultXml;

class NbpApiClient
{
    
    public const API_URL = 'http://api.nbp.pl/api/exchangerates/rates/a/eur';
    public const JSON_FORMAT = 1;
    public const XML_FORMAT = 2;

    private $curl = null;
    
    /**
     * Pobranie aktualnego kursu euro w formacie JSON
     *
     * @return NbpApiResultJson
     */
    public function getEuroExchangeRateJson(): NbpApiResultJson
    {
        $result = $this->getEuroExchangeRate(self::JSON_FORMAT);
        
        return $result;
    }
    
    /**
     * Pobranie aktualnego kursu euro w formacie XML
     *
     * @return NbpApiResultXml
     */
    public function getEuroExchangeRateXml(): NbpApiResultXml
    {
        $result = $this->getEuroExchangeRate(self::XML_FORMAT);
        
        return $result;
    }

    /**
     * Pobranie aktualnego kursu euro w zależności od żądanego formatu przekazanego w parametrze
     *
     * @param integer $format
     * @return NbpApiResultInterface
     */
    private function getEuroExchangeRate(int $format = NbpApiClient::JSON_FORMAT)
    {
        if (!$this->curl) {
            $this->curl = curl_init();
        }
        
        $this->setResponseFormat($format);
        
        $rawResult = $this->callApi();
        switch ($format) {
            case self::XML_FORMAT:
                $result = new NbpApiResultXml($rawResult);
                break;

            default:
                $result = new NbpApiResultJson($rawResult);
        }

        return $result;
    }
    
    /**
     * Ustawianie odpowiedniego żądania formatu odpowiedzi  w zależności od przekazanego parametru
     *
     * @param integer $format
     * @return void
     * @throws Exception
     */
    private function setResponseFormat(int $format = NbpApiClient::JSON_FORMAT): void
    {
        if ($format !== self::JSON_FORMAT && $format !== self::XML_FORMAT) {
            throw new \Exception("Błędny argument formatu", 1);
        }

        switch ($format) {
            case self::XML_FORMAT:
                $formatType = 'xml';
                break;

            default:
                $formatType = 'json';
        }
        
        $headers = [
           'Accept: application/' . $formatType
        ];

        $this->setRequestHeaders($headers);
    }
   
    /**
     * Wywołanie API przy użyciu curl
     *
     * @return string
     * @throws Exception
     */
    private function callApi()
    {
        curl_setopt($this->curl, CURLOPT_URL, self::API_URL);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    
        $result = curl_exec($this->curl);
        $httpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            throw new \Exception($result, 1);
        }

        curl_close($this->curl);
        $this->curl = null;

        return $result;
    }

    /**
     * Ustawianie nagłówków curl
     *
     * @param array $headers
     * @return void
     */
    private function setRequestHeaders(array $headers = [])
    {
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
    }
}
