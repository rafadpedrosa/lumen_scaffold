<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class {ltemplate} extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}
