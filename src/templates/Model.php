<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *     type="object",
 *     example={"anotherProperty":"modify here","{ltemplate}":"1"},
 *     @SWG\Property(type="integer", property="{ltemplate}_id"),
 *     @SWG\Property(type="string", property="anotherProperty"),
 * )
 */
class {ltemplate} extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}
