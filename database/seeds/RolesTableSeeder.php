<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('roles')->insert([
         'name' => 'Contributor',
         'description' => 'You are allowed to create a new Draft, and set it to Review. For Publishing, you have to ask the Editor',
      ]);
      DB::table('roles')->insert([
         'name' => 'Author',
         'description' => 'You are allowed to create a new Draft, set it to Review and Publish.',
      ]);
      DB::table('roles')->insert([
         'name' => 'Editor',
         'description' => 'You are allowed to create a new Draft, set it to Review and Publish and Publish a Contributors Article. You also may add new Users',
      ]);
      DB::table('roles')->insert([
         'name' => 'Admin',
         'description' => 'You may just do anything',
      ]);
    }
}
