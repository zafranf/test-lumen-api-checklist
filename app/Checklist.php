<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $fillable = ['description'];
    protected $dates = ['due', 'completed_at'];

    public function items()
    {
        return $this->hasMany('\App\ChecklistItem');
    }
}
