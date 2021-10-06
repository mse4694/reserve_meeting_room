<?php

namespace Database\Seeders;

use App\Models\Objective;
use Illuminate\Database\Seeder;

class ObjectiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1   การประชุม		
        // 2	การเรียน/การสอนก่อนปริญญา		
        // 3	การเรียน/การสอนหลังปริญญา		
        // 4	จัดเลี้ยง/พิธีการ		
        // 5	บรรยาย/อบรม		
        // 6	ซ่อมบำรุง		
        // 7	แนะนำและออกบูชแสดงผลิตภัณฑ์		
        // 8	อื่นๆ

        $objectives = [
                'การประชุม',		
            	'การเรียน/การสอนก่อนปริญญา',		
            	'การเรียน/การสอนหลังปริญญา',		
            	'จัดเลี้ยง/พิธีการ',		
            	'บรรยาย/อบรม',		
            	'ซ่อมบำรุง',	
            	'แนะนำและออกบูชแสดงผลิตภัณฑ์',		
            	'อื่นๆ'
        ];

        foreach ( $objectives as $objective) {
            Objective::create([
                'objective_name' => $objective,
                'objective_detail' => '-',
                'userin' => '10039018',
            ]);
        }
    }
}
