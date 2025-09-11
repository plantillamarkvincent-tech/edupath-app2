<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'code', 'name', 'description', 'years', 'possible_projects', 'possible_careers'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
