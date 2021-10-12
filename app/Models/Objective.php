<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Objective extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $fillable = [
        'objective_name',
        'objective_detail',
        'userin',
        'user_last_act'
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
