<?php

namespace App\Http\Repositories;

use App\Http\Controllers\CartController;
use App\Http\Interfaces\CartInterface;
use App\Http\Interfaces\ProductInterface;

use App\Http\Resources\ProductResource;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Traits\CreateMediaTrait;
use App\Http\Traits\DeleteMediaTrait;
use App\Models\Media;
use App\Models\Product;

use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CarttRepository implements  CartInterface
{
    use ApiDesignTrait;
    use CreateMediaTrait;
    use DeleteMediaTrait;

    private $productModel;
    private $mediaModel;



    public function __construct(Product $product, Media $media) {

        $this->productModel = $product;
        $this->mediaModel = $media;
    }


    public function addToCart($request)
    {

        $product_id = (int) $request->product_id;
        $cart = Session::get('cart');


        //session(['cart' => $cart]);

        // $new_session_id = Session::getId();

        //    $cart = [
        //     "user_id" => 1,
        //     "total" => 50,
        //     "items" => [
        //             1 => [],
        //             2 => [],
        //             3 => []
        //         ]
        //     ];



        if(isset($cart)){
            dd('has');

            dd(array_key_exists($product_id , $cart));

            $cart["total"] = 50;
            $cart["user_id"] = $request->user_id;
            $cart["items"][$product_id] = $request->except('_token');
            session()->put('cart', $cart);


        }else{

            dump('new');
            $cart["total"] = 50;
            $cart["user_id"] = $request->user_id;
            $cart["items"][$product_id] = $request->except('_token');
            session()->put('cart', $cart);
        }

        dd(session()->all());
    }


    public function addItemToCart($request)
    {
        $product_id = $request->product_id;
        //    $product = Product::find($id);
        //  $rowId = 456; // generate a unique() row ID // product id
        $userID = 1;
        // \Darryldecode\Cart\Cart::session($userID);

        CartFacade::session($userID)->add(

            $product_id,
            $request->name,
            $request->price,
            $request->qty
        );

        return CartFacade::getContent();

    }


    public function removeProductByUserId($userId)
    {
        CartFacade::session($userId)->clear();
        return CartFacade::getContent();
    }

    public function emptyCart($userID)
    {
        CartFacade::session($userID)->clear();

        return CartFacade::getContent();
    }

    public function retriveCart($userID)
    {
        return CartFacade::session($userID)->getContent();
//        return CartFacade::getContent();
    }

    public function increaseQTY($request)
    {
        $product_id = $request->product_id;
        $user_id = $request->user_id;
        CartFacade::session($user_id)->update($product_id,
            [
                'quantity' => $request->qty,

            ]);
        return CartFacade::session($request->user_id)->getContent();
    }

    public function decreaseQTY($request)
    {
        $product_id = $request->product_id;
        CartFacade::session($request->user_id)->update($product_id,
            [
                'qty' => - $request->qty,

            ]);
        return CartFacade::session($request->user_id)->getContent();
    }


    public function swapUserSession($user)
    {
        // if (!($user instanceof \App\User)) {
        //     return false;
        // }

        // $new_session_id = Session::getId(); //get new session_id after user sign in
        // $last_session = Session::getHandler()->read($user->last_session_id); // retrive last session

        // if ($last_session) {
        //     Session::getHandler()->destroy($user->last_session_id);
        // }

        // $user->last_session_id = $new_session_id;
        // $user->save();

        // return true;
    }

}
