<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'date',
        'time',
        'location',
        'price',
        'image',
        'production_id',
        'production_name'
    ];

    public function production_name()
    {
        return $this->belongsTo(Production_name::class, 'production_id');
    }

    public function productionName()
    {
        return $this->production_name->name;
    }
}
