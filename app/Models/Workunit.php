<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workunit extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'workunit_name',
        'workunit_type',
        'workunit_detail',
        'userin',
        'user_last_act'
    ];
}
