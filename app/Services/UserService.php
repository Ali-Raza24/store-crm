<?php

namespace App\Services;

use App\Constants\AppConstants;
use App\Constants\IStatus;
use App\Events\NewUserCreated as NewUserCreatedEvent;
use App\Events\UserUpdated as UserUpdatedEvent;
use App\Models\Business;
use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewUserCreated as NewUserCreatedNotify;
use App\Notifications\UserUpdated as UserUpdatedNotify;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private $imageService;

    /**
     * @var $model User
     */
    private $model;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        $this->model = new User();
    }

    public function findById($id){
        return User::find($id);
    }

    public function findByBusinessId($id){
        return User::whereBusinessId($id)->first();
    }

    public function save($request, $fromBusiness = false, $business_id = 0, $registeredUser = false) {

        if(isset($request->owner_email))
            $email = $request->owner_email;
        else
            $email = $request->email;

        if (!empty($request->id)){
            $user = $this->findById($request->id);
            if (!$user){
                $user = $this->model;
                $user->username = $email;
                $user->email = $email;
                $user->password = \Hash::make($request->password);
            }
        }
        if(!empty($request->business_id)){
            $user = $this->findByBusinessId($request->business_id);
            if (!$user){
                $user = $this->model;
                $user->username = $email;
                $user->email = $email;
                $user->password = \Hash::make($request->password);
            }
        }
        if (empty($request->id) && empty($request->business_id)){
            $user = $this->model;
            $user->username = $email;
            $user->email = $email;
            if(!empty($request->password)){
                $user->password = \Hash::make($request->password);
            }
        }

        $user->name = $request->name;

        if(Auth::user()->business_id > 0){
            $user->business_id = Auth::user()->business_id;
            $user->is_business = 1;
        } else{
            $user->is_business = 0;
            $user->business_id = 0;
        }

        // $user->is_business = 0;
        // if($request->is_business > 0)
        //     $user->is_business = $request->is_business;
        // $user->business_id = $request->business_id;
        $user->user_type_id = $request->user_type_id;
        $user->location_id = $request->location_id;
        $user->is_active = IStatus::ACTIVE;

        if ($registeredUser) {
            $user->email_verified_at = Carbon::now();
        }

        $user->save();

        $object = new \stdClass();
        $object->user = Auth::user()->name;
        $object->user_name = $user->name;

        if (empty($request->id) && !$registeredUser) {
            if (Auth::user()->business_id){
                Business::find(Auth::user()->business_id)->user->notify(new NewUserCreatedNotify($object));
            } else {
                User::whereEmail(config('app.admin_user'))->first()->notify(new NewUserCreatedNotify($object));
            }

            event(new NewUserCreatedEvent());
        }else {
            if (Auth::user()->business_id){
                Business::find(Auth::user()->business_id)->user->notify(new UserUpdatedNotify($object));
            } else {
                User::whereEmail(config('app.admin_user'))->first()->notify(new UserUpdatedNotify($object));
            }

            event(new UserUpdatedEvent());
        }

        if ($fromBusiness){
            $user->business_id = $business_id;
            $user->save();
            $plan = Plan::find($request->plan_id);
            if ($plan){
                $role = Role::find($plan->role_id);
                $user->assignRole($role);
            }
        }

        if(!empty($request->userRole)){
            $user->assignRole($request->userRole);
        }

        if ($fromBusiness == false) {
            if ($request->has('images')) {
                $this->imageService->saveImage($request, $user->id, User::class, "users");
            }
        }
        $user->createToken('authToken')->accessToken;

        if (!$user->hasVerifiedEmail()){
            $user->sendEmailVerificationNotification();
        }
        return $user;
    }

    public function update($request) {
        if(isset($request->owner_email))
            $email = $request->owner_email;
        else
            $email = $request->email;
        if (!empty($request->id)) {
            $user = $this->findById($request->id);
            if (!$user){
                $user = $this->model;
                $user->username = $email;
                $user->email = $email;
                $user->password = \Hash::make($request->password);
            }
        }
        if(!empty($request->business_id)) {
            $user = $this->findByBusinessId($request->business_id);
            if (!$user){
                $user = $this->model;
                $user->username = $email;
                $user->email = $email;
                $user->password = \Hash::make($request->password);
            }
        }
        if (empty($request->id) && empty($request->business_id)) {
            $user = $this->model;
            $user->username = $email;
            $user->email = $email;
            $user->password = \Hash::make($request->password);
        }

        $user->name = $request->name;

        if(Auth::user()->business_id > 0) {
            $user->business_id = Auth::user()->business_id;
            $user->is_business = 1;
        } else{
            $user->is_business = 0;
            $user->business_id = 0;
        }
        // if($request->is_business > 0)
        //     $user->is_business = $request->is_business;
        // $user->business_id = $request->business_id;
        $user->user_type_id = $request->user_type_id;
        $user->location_id = $request->location_id;
        $user->save();
        if(!empty($request->userRole)) {
            $user->assignRole($request->userRole);
        }

        if ($request->has('images')) {
            $this->imageService->saveImage($request, $user->id, User::class, "users");
        }
        $user->createToken('authToken')->accessToken;
        // $user->sendEmailVerificationNotification();
        return $user;
    }

    public function delete($id) {
        $user = User::find($id);
        $user->deleted_at = Carbon::now();
        $user->save();
    }

    public function search($params) {
        $users = User::whereNull('deleted_at');

        if (!empty($params['from_date'])){
            $users = $users->whereDate('created_at','>=', $params['from_date']);
        }
        if (!empty($params['to_date'])){
            $users = $users->whereDate('created_at','<=', $params['to_date']);
        }
        if (!empty($params['business_id'])){
            $users = $users->whereBusinessId($params['business_id']);
        }
        return $users->orderBy('id', 'desc')->paginate(AppConstants::PAGINATE_LARGE);
    }
}
