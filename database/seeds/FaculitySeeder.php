<?php

use Illuminate\Database\Seeder;

class FaculitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['BBA', 'MBA', 'BBS', 'CSIT', 'BCA', 'BIT'];

        $data = [];
        foreach ($names as $name) {
            $data[] = ['name' => $name];
        }
        
        DB::table('sm_faculities')->insert($data);
        
    }
}
