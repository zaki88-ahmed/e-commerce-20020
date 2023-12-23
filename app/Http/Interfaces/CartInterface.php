<?php
namespace App\Http\Interfaces;

interface CartInterface {


    public function addToCart($request);

    public function addItemToCart($request);

    public function removeProductByUserId($request);
    public function emptyCart($userId);

    public function retriveCart($userID);

    public function increaseQTY($request);

    public function swapUserSession($user);

}
