<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    // protected $fillable = [];
    protected $guarded = [];
    protected $dates = ['due', 'completed_at'];
}
