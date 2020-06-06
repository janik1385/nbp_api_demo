<?php

/**
 * Interfejs dla odpowiedzi NBP API
 */

namespace Demo\Nbp;

interface NbpApiResultInterface
{
    /**
     * Zamiana odpowiedzi w postaci stringu na odpowiedni obiekt
     *
     * @param string $result
     * @return object
     */
    public function parseResult(string $result): object;
    
    /**
     * Pobranie nazwy waluty
     *
     * @return string
     */
    public function getCurrency(): string;

    /**
     * Pobranie aktualnego kursu waluty
     *
     * @return float
     */
    public function getRate(): float;
    
    /**
     * Pobranie daty obowiązywania kursu waluty
     *
     * @return string
     */
    public function getEffectiveDate(): string;
}
