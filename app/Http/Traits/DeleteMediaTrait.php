<?php


namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;

trait DeleteMediaTrait{


    public function DeleteMediaTrait($modelId, $mediaModel, $mediableType)
    {
        $allMediables = DB::table('mediables')->where([['mediable_id', $modelId],['mediable_type', $mediableType]])->get();
        foreach ($allMediables as $mediable) {
            $media = $mediaModel->find($mediable->media_id);
            unlink(storage_path('app/public/' . $media->url));
            $media->delete();
        }
    }


}
