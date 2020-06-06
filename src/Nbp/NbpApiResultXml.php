<?php

/**
 *  Klasa dla odpowiedzi z NBP API w formacie XML
 */

namespace Demo\Nbp;

use Demo\Nbp\NbpApiResultInterface;

class NbpApiResultXml implements NbpApiResultInterface
{
    /**
     * @var SimpleXMLElement
     */
    private $xmlResult;
    
    /**
     * Konstruktor klasy - zamienia podany ciąg XML do obiektu SimpleXMLElement
     *
     * @param string $rawResult - surowa odpowiedź w postaci stringu XML
     */
    public function __construct(string $rawResult = '')
    {
        $this->xmlResult = $this->parseResult($rawResult);
    }
    
    /**
     * @inheritDoc
     */
    public function parseResult($result): object
    {
        return simplexml_load_string($result);
    }

    /**
     * @inheritDoc
     */
    public function getCurrency(): string
    {
        return $this->xmlResult->Currency ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getRate(): float
    {
        $rates = $this->xmlResult->Rates ?? null;
        
        return floatval($rates[0]->Rate->Mid) ?? 0;
    }
    
    /**
     * @inheritDoc
     */
    public function getEffectiveDate(): string
    {
        $rates = $this->xmlResult->Rates ?? null;

        return $rates[0]->Rate->EffectiveDate ?? null;
    }
}
