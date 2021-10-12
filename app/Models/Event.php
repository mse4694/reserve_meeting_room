<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'objective_id',
        'title',
        'detail',
        'start',
        'end',
        'prepare',
        'resourceId',
        'attendees',
        'responsible_person',
        'coordinator',
        'workunit_id',
        'tel',
        'equipment',
        'food_drink',
        'status',
        'reason',
        'questionnair',
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

    public function objective()
    {
        return $this->belongsTo(Objective::class);
    }
}
