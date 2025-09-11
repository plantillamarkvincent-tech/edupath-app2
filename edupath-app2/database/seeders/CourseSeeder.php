<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Program;

class CourseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$programIdByCode = Program::pluck('id', 'code');

		$courses = [
			['code' => 'IT101', 'title' => 'Introduction to IT', 'units' => 3, 'program_code' => 'BSIT', 'year_level' => 1, 'semester' => 1],
			['code' => 'IT102', 'title' => 'Programming 1', 'units' => 3, 'program_code' => 'BSIT', 'year_level' => 1, 'semester' => 1],
			['code' => 'BA101', 'title' => 'Intro to Business', 'units' => 3, 'program_code' => 'BSBA', 'year_level' => 1, 'semester' => 1],
			['code' => 'EDU101', 'title' => 'Foundations of Education', 'units' => 3, 'program_code' => 'BSED-ENG', 'year_level' => 1, 'semester' => 1],
		];

		foreach ($courses as $course) {
			$programId = $programIdByCode[$course['program_code']] ?? null;
			Course::updateOrCreate(
				['code' => $course['code']],
				[
					'title' => $course['title'],
					'units' => $course['units'],
					'program_id' => $programId,
					'year_level' => $course['year_level'],
					'semester' => $course['semester'],
				]
			);
		}
	}
}
