<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
          'title' => 'article',
          'description' => '',
        ]);
        DB::table('types')->insert([
          'title' => 'post',
          'description' => '',
        ]);
        DB::table('types')->insert([
          'title' => 'card',
          'description' => '',
        ]);
    }
}
