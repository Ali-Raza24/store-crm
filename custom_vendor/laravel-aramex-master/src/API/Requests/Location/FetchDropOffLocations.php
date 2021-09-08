<?php

namespace ExtremeSa\Aramex\API\Requests\Location;

use ExtremeSa\Aramex\API\Interfaces\Normalize;
use ExtremeSa\Aramex\API\Requests\API;
use ExtremeSa\Aramex\API\Response\Location\DropOffLocationsFetchingResponse;
use Exception;

/**
 * This method allows users to get list of the available ARAMEX offices within a certain country.
 * The required nodes to be filled are Client Info and Country Code.
 *
 * Class FetchDropOffLocations
 * @package ExtremeSa\Aramex\API\Requests\Location
 */
class FetchDropOffLocations extends API implements Normalize
{
    protected $v2_live_wsdl = 'https://ws.aramex.net/shippingapi.v2/location/service_1_0.svc?wsdl';
    protected $v2_test_wsdl = 'https://ws.aramex.net/shippingapi.v2/location/service_1_0.svc?wsdl';

    protected $v1_live_wsdl = 'custom_vendor/laravel-aramex-master/wsdls/live/location.xml';
    protected $v1_test_wsdl = 'custom_vendor/laravel-aramex-master/wsdls/test/location.xml';

}
