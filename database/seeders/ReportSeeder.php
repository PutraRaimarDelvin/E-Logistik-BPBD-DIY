<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['employee'=>'Danny Murta','email'=>'danny@example.com','department'=>'Technology Department','role'=>'Head of Technology','status'=>'done'],
            ['employee'=>'Sinta Arya','email'=>'sinta@example.com','department'=>'Technology Department','role'=>'Operations','status'=>'open'],
            ['employee'=>'Yusuf K','email'=>'yusuf@example.com','department'=>'Technology Department','role'=>'Lead','status'=>'open'],
        ];
        foreach ($rows as $r) Report::create($r);
    }
}
