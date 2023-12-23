<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 * @OA\Schema(
 * required={"image",""},
 * @OA\Xml(name="Media"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="image", type="string", readOnly="true", description="image path http//:public/image.jpg"),
 * )
 */

class Media extends Model
{
    use HasFactory;
    protected  $table = 'medias';


}
