<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentRequest extends Model
{
	use HasFactory;

	protected $fillable = [
		'user_id',
		'program_id',
		'full_name',
		'email',
		'contact_number',
		'address',
		'last_school_attended',
		'school_year',
		'status',
		'admin_note',
	];

	public function program()
	{
		return $this->belongsTo(Program::class);
	}
}
