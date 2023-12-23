<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\AuthInterface;
use App\Http\Interfaces\BrandInterface;
use App\Http\Requests\BrandRequest;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Traits\ApiDesignTrait;



use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

//use App\Http\Interfaces\PostInterface;
//use App\Http\Interfaces\PostInterface;



class AuthController extends Controller
{


    private $authInterface;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function register(Request $request){
        //dd($request);
        return $this->authInterface->register($request);
    }

    public function login(Request $request){
        //dd($request);
        return $this->authInterface->login($request);
    }

    public function logout(Request $request){
        //dd($request);
        return $this->authInterface->logout($request);
    }

}
