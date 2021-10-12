<?php

namespace Database\Seeders;

use App\Models\Event;
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
        // $z = new DateTimeZone('Asia/Bangkok');
        // $d = new DateTime('NOW');
        // $d->setTimezone($z)->format('Y-m-d\TH:i:s:');

        $eventsJSON = '[
            {"objective_id": 1, "title": "ประชุมหน่วย IT", "start": "2021-10-12T13:00:00", "end": "2021-10-12T16:30:00", "resourceId": 4, "attendees": 8, "responsible_person": "เจ้าหน้าที่ห้องประชุม1", "coordinator": "นายทดสอบ เห็นตะวัน", "workunit_id": 32, "tel": "02-2221111 ต่อ 1860", "userin": "10039018"},
            {"objective_id": 5, "title": "เก็บชุด PPE ประจำวันหลังเลิก ward", "start": "2021-10-13T16:00:00", "end": "2021-10-13T17:00:00", "resourceId": 2, "attendees": 20, "responsible_person": "เจ้าหน้าที่ห้องประชุม2", "coordinator": "นางสาวฟ้าสาง ทอรุ้ง", "workunit_id": 5, "tel": "02-2223333 ต่อ 1022", "userin": "10039018"},
            {"objective_id": 4, "title": "เตรียมจัดงานลอยกระทง", "start": "2021-10-14T10:00:00", "end": "2021-10-14T15:30:00", "resourceId": 1, "attendees": 70, "responsible_person": "เจ้าหน้าที่ห้องประชุม3", "coordinator": "นางงาม จักรยาน", "workunit_id": 40, "tel": "02-2224444 ต่อ 1000", "userin": "10039018"},
            {"objective_id": 1, "title": "ประชุมหัวหน้าหน่วยต่างๆ ของภาควิชาอายุรศาสตร์ เกี่ยวกับการเตรียมพร้อม PDPA", "start": "2021-10-15T09:00:00", "end": "2021-10-15T12:00:00", "resourceId": 3, "attendees": 30, "responsible_person": "เจ้าหน้าที่ห้องประชุม2", "coordinator": "นางงาม จักรยาน", "workunit_id": 40, "tel": "02-2224444 ต่อ 1000", "userin": "10039018"},
            {"objective_id": 4, "title": "เตรียมงานเกษียณอายุ ", "start": "2021-10-15T13:00:00", "end": "2021-10-15T16:30:00", "resourceId": 3, "attendees": 30, "responsible_person": "เจ้าหน้าที่ห้องประชุม3", "coordinator": "นางงาม จักรยาน", "workunit_id": 40, "tel": "02-2224444 ต่อ 1000", "userin": "10039018"},
            {"objective_id": 4, "title": "ประชุมลับ ปลดระวาง พี่ว๊าก", "start": "2021-10-15T16:40:00", "end": "2021-10-15T17:30:00", "resourceId": 3, "attendees": 500, "responsible_person": "เจ้าหน้าที่ห้องประชุม3", "coordinator": "นางงาม จักรยาน", "workunit_id": 40, "tel": "02-2224444 ต่อ 1000", "userin": "10039018"}
        ]';

        $events = json_decode($eventsJSON, true);

        foreach ( $events as $event) {
            // \Log::info($event['id']);
            // \Log::info($event['title']);
            // \Log::info($event['start']);
            // \Log::info("---------------------");
            Event::create([
                'objective_id' => $event['objective_id'],
                'title' => $event['title'],
                'start' => $event['start'],
                'end' => $event['end'],
                'resourceId' => $event['resourceId'],
                'attendees' => $event['attendees'],
                'responsible_person' => $event['responsible_person'],
                'coordinator' => $event['coordinator'],
                'workunit_id' => $event['workunit_id'],
                'tel' => $event['tel'],
                'userin' => $event['userin']
            ]);
        }
    }
}
