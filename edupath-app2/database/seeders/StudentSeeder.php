<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Program;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$program = Program::first();

		$user = User::firstOrCreate(
			['email' => 'student@example.com'],
			[
				'name' => 'Sample Student',
				'password' => bcrypt('password'),
				'role' => 'student',
			]
		);

		Student::updateOrCreate(
			['user_id' => $user->id],
			[
				'student_number' => 'S-' . now()->format('Y') . '-' . Str::padLeft((string) random_int(1, 9999), 4, '0'),
				'first_name' => 'Sample',
				'last_name' => 'Student',
				'program_id' => $program?->id,
				'year_level' => '1',
			]
		);
	}
}
