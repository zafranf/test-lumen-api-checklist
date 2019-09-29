<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    // protected $fillable = [];
    protected $guarded = [];
    protected $dates = ['due', 'completed_at'];

    public function items()
    {
        return $this->hasMany('\App\ChecklistItem');
    }
}
