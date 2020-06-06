<?php

/**
 *  Klasa dla odpowiedzi z NBP API w formacie JSON
 */

namespace Demo\Nbp;

use Demo\Nbp\NbpApiResultInterface;

class NbpApiResultJson implements NbpApiResultInterface
{
    /**
     * @var stdClass
     */
    private $jsonResult;

    /**
     * Konstruktor klasy - zamienia podany ciąg JSON do obiektu stdClass
     *
     * @param string $rawResult - surowa odpowiedź w postaci stringu JSON
     */
    public function __construct(string $rawResult = '')
    {
        $this->jsonResult = $this->parseResult($rawResult);
    }
    
    /**
     * @inheritDoc
     */
    public function parseResult($result): object
    {
        return json_decode($result);
    }

    /**
     * @inheritDoc
     */
    public function getCurrency(): string
    {
        return $this->jsonResult->currency ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getRate(): float
    {
        $rates = $this->jsonResult->rates ?? null;
        
        return floatval($rates[0]->mid) ?? 0;
    }
    
    /**
     * @inheritDoc
     */
    public function getEffectiveDate(): string
    {
        $rates = $this->jsonResult->rates ?? null;

        return $rates[0]->effectiveDate ?? null;
    }
}
