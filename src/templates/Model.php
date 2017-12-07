<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class {template} extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
