<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function forgetPassword(Request $request){
        return view("business.auth.forgot-password");
    }

    public function resetPassword(Request $request){
        return view("business.auth.reset-password");
    }

    public function resetSuccess(Request $request){
        return view("business.auth.reset-success-message");
    }
}
