<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'name',
        'checklist_id',
        'created_by',
        'updated_by',
    ];

    public function checklist()
    {
        return $this->belongsTo('\App\Checklist');
    }
}
