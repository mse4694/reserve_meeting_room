<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $z = new DateTimeZone('Asia/Bangkok');
        $d = new DateTime('NOW');
        $d->setTimezone($z)->format('Y-m-d\TH:i:s:');

        $events = [
            {"id": 1, "title": "ประชุมหน่วย IT", "start": "2021-10-12T13:00:00", "end": "2021-10-12T16:30:00", "resourceId": 1, "attendees": 8, "coordinator": "นายทดสอบ เห็นตะวัน", "workunit_id": 32, "tel": "02-2221111 ต่อ 1860", "userin": "10039018"},
            {"id": 2, "title": "เก็บชุด PPE ประจำวันหลังเลิก ward", "start": "2021-10-13T16:00:00", "end": "2021-10-13T17:00:00", "resourceId": 2, "attendees": 20, "coordinator": "นางสาวฟ้าสาง ทอรุ้ง", "workunit_id": 5, "tel": "02-2223333 ต่อ 1022", "userin": "10039018"}
        ];
    }
}
