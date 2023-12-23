<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\BrandInterface;

use App\Http\Resources\BrandResource;
use App\Http\Traits\ApiDesignTrait;
use App\Http\Traits\CreateMediaTrait;
use App\Http\Traits\DeleteMediaTrait;
use App\Models\Brand;
use App\Models\Media;
use App\Models\Product;

use Illuminate\Http\Request;

class BrandRepository implements BrandInterface {
    use ApiDesignTrait;
    use CreateMediaTrait;
    use DeleteMediaTrait;

    private $brandModel;
    private $mediaModel;



    public function __construct(Brand $brand, Media $media) {

        $this->brandModel = $brand;
        $this->mediaModel = $media;
    }



    public function createBrand($request)
    {
        // TODO: Implement createBrand() method.
        $brand = $this->brandModel::create($request->all());

        if($request->media){
            $this->CreateMediaTrait($request->media, $brand, '/brand_medias');
        }
        return $this->ApiResponse(200, 'Brand Was Created', null, BrandResource::make($brand));
    }


    public function allBrands()
    {
        // TODO: Implement allBrands() method.
        $brands = $this->brandModel::get();
        return $this->ApiResponse(200, 'Done', null,  BrandResource::collection($brands));
    }

    public function deleteBrand($request)
    {
        // TODO: Implement deleteBrand() method.
        $brand = $this->brandModel::find($request->brand_id);
        if($brand){
            $this->DeleteMediaTrait($brand->id, $this->mediaModel, 'App\Models\Brand');
            $brand->delete();
            return $this->ApiResponse(200, 'Brand Was Deleted', null, BrandResource::make($brand));
        }
        return $this->ApiResponse(422, 'This Brand Not Found');
    }

    public function restoreBrand($request)
    {
        // TODO: Implement restoreBrand() method.
        $brand = $this->brandModel->withTrashed()->find($request->brand_id);
        if (!is_null($brand->deleted_at)) {
            $brand->restore();
            return $this->ApiResponse(200,'Brand restored successfully');
        }
        return $this->ApiResponse(200,'Brand already restored');
    }

    public function specificBrand($request)
    {
        // TODO: Implement specificBrand() method.
        $brand = $this->brandModel::find($request->brand_id);
        if($brand){
            return $this->ApiResponse(200, 'Done', null, BrandResource::make($brand));
        }
        return  $this->ApiResponse(404, 'Not Found');
    }

    public function updateBrand($request)
    {
        // TODO: Implement updateBrand() method.
        $brand = $this->brandModel::find($request->brand_id);
        $brand->update($request->all());
        if($request->media){
            $this->DeleteMediaTrait($brand->id, $this->mediaModel, 'App\Models\Brand');
            $this->CreateMediaTrait($request->media, $brand, '/brand_medias');
        }
        return $this->ApiResponse(200, 'Brand Was Updated', null, BrandResource::make($brand));
    }
}
