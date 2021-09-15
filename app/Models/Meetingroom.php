<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meetingroom extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $fillable = [
        'building_id',
        'floor',
        'capacity',
        'price',
        'fullname',
        'shortname',
        'description',
        'userin',
        'user_last_act',
        'status',
        'img_file'

    ];

    // สำหรับ column ที่ประกาศเอาไว้ว่าเป็นชนิด json
    protected $casts = [
        'description' => 'array',
        'capacity' => 'array',
        'price' => 'array',
        'img_file' => 'array',
    ];
}
