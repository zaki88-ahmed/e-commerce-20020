<?php
namespace App\Http\Interfaces;


interface ProductInterface {


    public function createProduct($request);

    public function allProducts();

    public function deleteProduct($request);
    public function restoreProduct($request);

    public function specificProduct($request);

    public function updateProduct($request);

    public function deleteMedia($request);

}
