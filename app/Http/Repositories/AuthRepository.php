<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AuthInterface;
use App\Http\Interfaces\BrandInterface;

use App\Http\Resources\BrandResource;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Traits\CreateMediaTrait;
use App\Http\Traits\DeleteMediaTrait;
use App\Models\Brand;
use App\Models\Media;
use App\Models\Product;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpseclib3\Crypt\Hash;

class AuthRepository implements AuthInterface {
    use ApiDesignTrait;
    use CreateMediaTrait;
    use DeleteMediaTrait;

    private $userModel;


    public function __construct(User $user) {

        $this->userModel = $user;
    }


    public function register($request)
    {
        // TODO: Implement createBrand() method.
//        dd($request->all());
        $info = $request->all();
        $user = User::create($info);
        return $this->ApiResponse(200, 'User Registered Successfully', null, $user);
    }


    public function login($request)
    {
        // TODO: Implement deleteBrand() method.
        $user = User::where('email', $request->email)->first();

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (auth()->attempt($data)){
            $token = $user->createToken('')->accessToken->token;
            return $this->ApiResponse(200, 'User Login Successfully', null, $token);
        }
        return $this->ApiResponse(401, 'Bad credentials');
    }

    public function logout($request)
    {
        // TODO: Implement deleteBrand() method.

            return $this->ApiResponse(200, 'User Loggedout Successfully');
    }

}
