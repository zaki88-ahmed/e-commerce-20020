<?php

namespace App\Http\Controllers;

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



class BrandController extends Controller
{


    private $brandInterface;

    public function __construct(BrandInterface $brandInterface)
    {
        $this->brandInterface = $brandInterface;
    }

    public function createBrand(BrandRequest $request){
        //dd($request);
        return $this->brandInterface->createBrand($request);
    }

    public function allBrands(){
        //dd($request);
        return $this->brandInterface->allBrands();
    }

    public function deleteBrand(BrandRequest $request){

        return $this->brandInterface->deleteBrand($request);
    }


    public function specificBrand(BrandRequest $request){

        return $this->brandInterface->specificBrand($request);
    }


    public function updateBrand(BrandRequest $request){

        return $this->brandInterface->updateBrand($request);
    }

    public function restoreBrand(BrandRequest $request){

        return $this->brandInterface->restoreBrand($request);
    }


}
