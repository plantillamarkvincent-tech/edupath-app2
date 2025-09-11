<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'code','title','units','program_id','year_level','semester'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
