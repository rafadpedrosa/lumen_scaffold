<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *     type="object",
 *     example={"name":"{template} name","description":"{template} 1"},
 *     @SWG\Property(type="integer", property="{ltemplate}_id"),
 *     @SWG\Property(type="string", property="description"),
 * )
 */
class {template} extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}
