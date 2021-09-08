<?php

namespace App\Http\Controllers\Api;

use App\Constants\AramexConstants;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Store;
use App\Services\OrderService;
use ExtremeSa\Aramex\API\Classes\{Address, ShipmentDetails, Weight};
use ExtremeSa\Aramex\Aramex;
use Illuminate\Http\Request;

class OrderController extends ApiBaseController
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        parent::__construct();
    }

    public function save(OrderRequest $request)
    {
        $order = $this->orderService->save($request);
        if ($order){
            return $this->sendSuccess('Order placed successfully', new OrderResource($order));
        }
        return $this->sendError('An error occurred while placing order');
    }

    public function track(Request $request, $id)
    {
        $order = $this->orderService->findByOrderNumber($id);
        if ($order){
            return $this->sendSuccess('OK', new OrderResource($order));
        }
        return $this->sendError('Your tracking link is not valid',[],'Your tracking link is not valid');
    }

    public function validateRequest(OrderRequest $request)
    {
        return $this->sendSuccess('OK', []);
    }

    public function calculate_rate(Request $request)
    {
        $request->validate(
            [
                'city' => 'required',
                'area' => 'required',
                'number_of_products' => 'required',
                'store_id' => 'required',
            ]
        );

        $sourceAddress = new Address();
        $sourceAddress
            ->setLine1(!empty(Store::find($request->store_id)) ? Store::find($request->store_id)->address_1 : '1')
            ->setCountryCode('AE')
            ->setStateOrProvinceCode(Store::find($request->store_id)->state->name)
            ->setCity(Store::find($request->store_id)->state->name);

        $destination = new Address();
        $destination
            ->setLine1($request->area)
            ->setCity($request->city)
            ->setStateOrProvinceCode($request->city)
            ->setCountryCode('AE');

        $weight = new Weight();
        if ($request->has('weight')){
            $weight->setValue($request->weight);
        }else{
            $weight->setValue(1);
        }


        $weight->setUnit('KG');

        $details = new ShipmentDetails();
        $details->setActualWeight($weight);
        $details->setNumberOfPieces($request->number_of_products);

        $response = Aramex::calculateRate()
            ->setOriginalAddress($sourceAddress)
            ->setDestinationAddress($destination)
            ->setShipmentDetails($details)
            ->setPreferredCurrencyCode('AED')
            ->run();

        if ($response->isSuccessful()){
            return $this->sendSuccess('Shipping Rates', $response->getTotalAmount()->getValue());
        }
        return $this->sendError('Shipping address is not valid', $response->getMessages());
    }
}
