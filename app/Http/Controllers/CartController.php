<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CartInterface;
use Illuminate\Http\Request;
use \Darryldecode\Cart\Cart;
use Darryldecode\Cart\Facades\CartFacade;

class CartController extends Controller
{

    private $cartInterface;


   public function __construct(CartInterface $cartInterface){

       $this->cartInterface = $cartInterface;
   }
    public function addToCart(Request $request)
    {
//        return 'cc';
        return $this->cartInterface->addToCart($request);
    }


    public function addItemToCart(Request $request)
    {
        return $this->cartInterface->addItemToCart($request);
    }


    public function removeProductByUserId($userId)
    {
        return $this->cartInterface->removeProductByUserId($userId);
    }

    public function emptyCart($userId)
    {
        return $this->cartInterface->emptyCart($userId);
    }

    public function retriveCart($userID)
    {
        return $this->cartInterface->retriveCart($userID);
    }

    public function increaseQTY(Request $request)
    {
        return $this->cartInterface->increaseQTY($request);
    }


    public function swapUserSession($user)
    {
        return $this->cartInterface->swapUserSession($user);
    }
}
