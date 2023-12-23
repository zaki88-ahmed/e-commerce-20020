<?php


namespace App\Http\Traits;

use App\Models\Media;
use Illuminate\Support\Facades\Storage;

trait CreateMediaTrait{


    public function CreateMediaTrait($request, $model, $path){

        foreach ($request as $media){
            $mediaUrl = Storage::disk('public')->put($path, $media);
            $media = new Media();
            $media->type = 'post';
            $media->url = $mediaUrl;
            $media->save();
            $model->medias()->attach($media->id, ['type'=>'post']);
        }
    }

}
