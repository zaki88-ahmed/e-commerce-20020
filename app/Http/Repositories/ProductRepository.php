<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ProductInterface;

use App\Http\Resources\ProductResource;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Traits\CreateMediaTrait;
use App\Http\Traits\DeleteMediaTrait;
use App\Models\Media;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductInterface {
    use ApiDesignTrait;
    use CreateMediaTrait;
    use DeleteMediaTrait;

    private $productModel;
    private $mediaModel;



    public function __construct(Product $product, Media $media) {

        $this->productModel = $product;
        $this->mediaModel = $media;
    }


    public function createProduct($request)
    {
        // TODO: Implement createProduct() method.
        $product = $this->productModel::create($request->all());

        if($request->media){
            $this->CreateMediaTrait($request->media, $product, '/product_medias');
        }
        return $this->ApiResponse(200, 'Product Was Created', null, ProductResource::make($product));
    }

    public function allProducts()
    {
        // TODO: Implement allProducts() method.
        $products = $this->productModel::get();
        return $this->ApiResponse(200, 'Done', null,  ProductResource::collection($products));
    }

    public function deleteProduct($request)
    {
        // TODO: Implement deleteProduct() method.
        $product = $this->productModel::find($request->product_id);
        if($product){
            $this->DeleteMediaTrait($product->id, $this->mediaModel, 'App\Models\Product');
            $product->delete();
            return $this->ApiResponse(200, 'Product Was Deleted', null, ProductResource::make($product));
        }
        return $this->ApiResponse(422, 'This Product Not Found');

    }

    public function specificProduct($request)
    {
        // TODO: Implement specificProduct() method.
        $product = $this->productModel::find($request->product_id);
        if($product){
            return $this->ApiResponse(200, 'Done', null, ProductResource::make($product));
        }
        return  $this->ApiResponse(404, 'Not Found');
    }

    public function updateProduct($request)
    {
        // TODO: Implement updateProduct() method.

        $product = $this->productModel::find($request->product_id);

        $product->update($request->all());
        if($request->media){
            $this->DeleteMediaTrait($product->id, $this->mediaModel, 'App\Models\Product');
            $this->CreateMediaTrait($request->media, $product, '/product_medias');
        }
        return $this->ApiResponse(200, 'Product Was Updated', null, ProductResource::make($product));
    }

    public function restoreProduct($request)
    {
        // TODO: Implement restoreProduct() method.
        $product = $this->productModel->withTrashed()->find($request->product_id);
        if (!is_null($product->deleted_at)) {
            $product->restore();
            return $this->ApiResponse(200,'Product restored successfully');
        }
        return $this->ApiResponse(200,'Product already restored');

    }

    public function deleteMedia($request)
    {
        // TODO: Implement deleteMedia() method.

            $media = $this->mediaModel->find($request->media_id);
            if($media){
                unlink(storage_path('app/public/' . $media->url));
                $media->delete();
                return  $this->ApiResponse(200, 'Media was deleted');
            }
        return  $this->ApiResponse(404, 'Media Not Found');

    }
}
