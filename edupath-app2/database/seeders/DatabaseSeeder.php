<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		// Admin user
		User::firstOrCreate(
			['email' => 'admin@example.com'],
			[
				'name' => 'System Admin',
				'password' => Hash::make('password'),
				'role' => 'admin',
			]
		);

		$this->call([
			ProgramSeeder::class,
			CourseSeeder::class,
			StudentSeeder::class,
		]);
	}
}
