<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Employee extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<10;$i++) {
            $time = new \DateTime();
            DB::table('employee')->insert([
                'name'  =>  'Consultant' . $i,
                'email' =>  'consultant' . $i . '@tld.ext',
                'phone' =>  '077016322' . $i,
                'created_at'    =>  $time->format('Y-m-d h:i:s'),
                'updated_at'    =>  $time->format('Y-m-d h:i:s'),
            ]);
        }
    }
}
