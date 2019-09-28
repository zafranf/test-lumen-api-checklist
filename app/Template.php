<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{

    public function checklist()
    {
        return $this->belongsTo('\App\Checklist');
    }
}
