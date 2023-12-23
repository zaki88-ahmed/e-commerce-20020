<?php
namespace App\Http\Interfaces;


interface BrandInterface {


    public function createBrand($request);

    public function allBrands();

    public function deleteBrand($request);
    public function restoreBrand($request);

    public function specificBrand($request);

    public function updateBrand($request);

}
