<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'group_name' => 'user',
			'created_at' => 'now()',
			'updated_at' => 'now()',
        ]);

		DB::table('groups')->insert([
            'group_name' => 'admin',
			'created_at' => 'now()',
			'updated_at' => 'now()',
        ]);
    }
}
