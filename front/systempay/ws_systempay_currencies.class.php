<?php
if(!@class_exists('SystempayCurrency', false)) {
 class SystempayCurrency {
    var $alpha3;
    var $num;
    var $decimals;
  
    function SystempayCurrency($alpha3, $num, $decimals = 2) {
      $this->alpha3 = $alpha3;
      $this->num = $num;
      $this->decimals = $decimals;
    }
  
    function convertAmountToInteger($float) {
      $coef = pow(10, $this->decimals);
  
      return intval(strval($float * $coef));
    }
  
    function convertAmountToFloat($integer) {
      $coef = pow(10, $this->decimals);
  
      return floatval($integer) / $coef;
    }
  }
}

if(!@class_exists('SystempayCurrenciesManager', false)) {
  class SystempayCurrenciesManager{
    private $_currencies;
    private $_supporteds;

    public function __construct() {
      $this->supporteds = array(
        array('ARS', 32, 2), array('AUD', 36, 2), array('KHR', 116, 0), array('CAD', 124, 2), array('CNY', 156, 1), array('HRK', 191, 2), array('CZK', 203, 2), array('DKK', 208, 2), array('EKK', 233, 2), array('HKD', 344, 2), array('HUF', 348, 2), array('ISK', 352, 0), array('IDR', 360, 0), array('JPY', 392, 0), array('KRW', 410, 0), array('LVL', 428, 2), array('LTL', 440, 2), array('MYR', 458, 2), array('MXN', 484, 2), array('NZD', 554, 2), array('NOK', 578, 2), array('PHP', 608, 2), array('RUB', 643, 2), array('SGD', 702, 2), array('ZAR', 710, 2), array('SEK', 752, 2), array('CHF', 756, 2), array('THB', 764, 2), array('GBP', 826, 2), array('USD', 840, 2), array('TWD', 901, 1), array('RON', 946, 2), array('TRY', 949, 2), array('XOF', 952, 0), array('BGN', 975, 2), array('EUR', 978, 2), array('PLN', 985, 2), array('BRL', 986, 2)
      );
      $this->constructCurrencies();
    }
    
    private function constructCurrencies(){
      $systempayCurrencies = array();
      foreach($this->supporteds as $currency) {
        array_push($systempayCurrencies, new SystempayCurrency($currency[0], $currency[1], $currency[2]));
      }
      $this->currencies = $systempayCurrencies;
    }

    public function getCurrencies() {
      return $this->currencies;
    }

        /**
     * Return a currency from its iso 3-letters code
     * @static
     * @param string $alpha3
     * @return SystempayCurrency
     */
    public function findCurrencyByAlphaCode($alpha3) {
      foreach ($this->currencies as $currency) {
        /** @var SystempayCurrency $currency */
        if ($currency->alpha3 == $alpha3) {
          return $currency;
        }
      }
      return null;
    }
  
    /**
     * Returns a currency form its iso numeric code
     * @static
     * @param int $num
     * @return SystempayCurrency
     */
    public function findCurrencyByNumCode($numeric) {
      foreach ($this->currencies as $currency) {
        /** @var SystempayCurrency $currency */
        if ($currency->num == $numeric) {
          return $currency;
        }
      }
      return null;
    }
  
    /**
     * Returns a currency numeric code from its 3-letters code
     * @static
     * @param string $alpha3
     * @return int
     */
    public function getCurrencyNumCode($alpha3) {
      $currency = $this->findCurrencyByAlphaCode($alpha3);
      return is_a($currency, 'SystempayCurrency') ? $currency->num : null;
    }
  }
}
?>