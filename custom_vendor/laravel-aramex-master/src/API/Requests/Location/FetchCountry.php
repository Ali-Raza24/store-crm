<?php

namespace ExtremeSa\Aramex\API\Requests\Location;

use Exception;
use ExtremeSa\Aramex\API\Interfaces\Normalize;
use ExtremeSa\Aramex\API\Requests\API;
use ExtremeSa\Aramex\API\Response\Location\CountryFetchingResponse;

/**
 * This method allows users to get details of a certain country.
 *
 * Class FetchCountry
 * @package ExtremeSa\Aramex\API\Requests\Location
 */
class FetchCountry extends API implements Normalize
{
    protected $v2_live_wsdl = 'https://ws.aramex.net/shippingapi.v2/location/service_1_0.svc?wsdl';
    protected $v2_test_wsdl = 'https://ws.aramex.net/shippingapi.v2/location/service_1_0.svc?wsdl';

    protected $v1_live_wsdl = 'custom_vendor/laravel-aramex-master/wsdls/live/location.xml';
    protected $v1_test_wsdl = 'custom_vendor/laravel-aramex-master/wsdls/test/location.xml';

    private $code;

    /**
     * @return CountryFetchingResponse
     * @throws Exception
     */
    public function run()
    {
        $this->validate();

        return CountryFetchingResponse::make($this->soapClient->FetchCountry($this->normalize()));
    }

    protected function validate()
    {
        parent::validate();

        if (!$this->code) {
            throw new Exception('Should provide country code!');
        }
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return FetchCountry
     */
    public function setCode(string $code): FetchCountry
    {
        $this->code = $code;
        return $this;
    }


    public function normalize(): array
    {
        return array_merge([
            'Code' => $this->getCode()
        ], parent::normalize());
    }
}
