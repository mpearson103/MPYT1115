<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// Create default regular user
		DB::table('users')->insert([
            'username' => 'default',
            'password' => bcrypt('default'),
			'created_at' => 'now()',
			'updated_at' => 'now()',
        ]);

		// Create default admin user
        DB::table('users')->insert([
            'username' => 'admin',
            'password' => bcrypt('admin'),
			'group_id' => 2,
			'created_at' => 'now()',
			'updated_at' => 'now()',
        ]);
    }
}
