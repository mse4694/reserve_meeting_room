<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'start',
        'end',
        'resourceId',
        'attendees',
        'coordinator',
        'workunit_id',
        'tel',
        'equipment',
        'food_drink',
        'status',
        'userin',
        'user_last_act'
    ];

    // สำหรับ column ที่ประกาศเอาไว้ว่าเป็นชนิด json
    protected $casts = [
        'equipment' => 'array',
        'food_drink' => 'array',
    ];

    public function workunit()
    {
        return $this->belongsTo(Workunit::class);
    }
}
