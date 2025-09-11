<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$programs = [
			['code' => 'BSIT', 'name' => 'BS in Information Technology', 'description' => 'IT program focused on software, networks, and systems', 'years' => 4],
			['code' => 'BSA', 'name' => 'BS in Agriculture', 'description' => 'Agricultural science and technology', 'years' => 4],
			['code' => 'HM', 'name' => 'Hospitality Management', 'description' => 'Hotel and restaurant management', 'years' => 4],
			['code' => 'BSES', 'name' => 'BS in Environmental Science', 'description' => 'Environmental systems and sustainability', 'years' => 4],
			['code' => 'BSMATH', 'name' => 'BS in Mathematics', 'description' => 'Mathematical theory and applied math', 'years' => 4],
			['code' => 'BSAM', 'name' => 'BS in Agriculture Management', 'description' => 'Agriculture business and management', 'years' => 4],
		];

		foreach ($programs as $program) {
			Program::updateOrCreate(['code' => $program['code']], $program);
		}
	}
}
