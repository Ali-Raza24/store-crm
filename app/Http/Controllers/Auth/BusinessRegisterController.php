<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\BusinessRegisterRequest;
use App\Http\Resources\BusinessResource;
use App\Services\BusinessService;

class BusinessRegisterController extends ApiBaseController
{
    private $businessService;

    public function __construct(BusinessService $businessService)
    {
        $this->businessService = $businessService;
    }

    public function save(BusinessRegisterRequest $request)
    {
        request()->request->add(['owner_email' => $request->email]);

        $business = $this->businessService->register($request);
        if ($business) {
            $business = $this->businessService->findById($business);
            return $this->sendSuccess(
                'An email sent to your email address. Please verify you account to continue',
                new BusinessResource($business));
        }else {
            return $this->sendError( 'Error while registering business');
        }
    }
}
