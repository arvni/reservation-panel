<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Doctor;
use App\Models\Time;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $doctors = [[
            "image" => "/images/dr-saber.png",
            "title" => "Dr.Siamak Saber",
            "subtitle" => "(MD;MSC;PHD)",
            "specialty" => "Genetic Consultant",
        ], [
            "image" => "/images/dr-abeer.png",
            "title" => "Dr.Abeer Alsayegh",
            "subtitle" => "(MD;PHD)",
            "specialty" => "Genetic Consultant",
        ]
        ];
        $times = [
            ["started_at" => "10:00", "ended_at" => "10:30", "disabled" => false],
            ["started_at" => "10:30", "ended_at" => "11:00", "disabled" => false],
            ["started_at" => "11:00", "ended_at" => "11:30", "disabled" => false],
            ["started_at" => "11:30", "ended_at" => "12:00", "disabled" => false],
            ["started_at" => "12:00", "ended_at" => "12:30", "disabled" => false],
            ["started_at" => "12:30", "ended_at" => "13:00", "disabled" => false],
            ["started_at" => "13:00", "ended_at" => "13:30", "disabled" => false],
            ["started_at" => "13:30", "ended_at" => "14:00", "disabled" => false],
            ["started_at" => "14:00", "ended_at" => "14:30", "disabled" => false],
            ["started_at" => "14:30", "ended_at" => "15:00", "disabled" => false],
            ["started_at" => "15:00", "ended_at" => "15:30", "disabled" => true],
            ["started_at" => "15:30", "ended_at" => "16:00", "disabled" => false],
            ["started_at" => "16:00", "ended_at" => "16:30", "disabled" => false],
            ["started_at" => "16:30", "ended_at" => "17:00", "disabled" => false],
            ["started_at" => "17:00", "ended_at" => "17:30", "disabled" => false],
            ["started_at" => "17:30", "ended_at" => "18:00", "disabled" => false],
        ];
        foreach ($doctors as $doctor){
            $dr=Doctor::create($doctor);
            foreach ($times as $time){
                $tm=new Time([
                    "started_at"=>Carbon::parse("2023-11-26 ".$time["started_at"]),
                    "ended_at"=>Carbon::parse("2023-11-26 ".$time["ended_at"]),
                    "title"=>$time["started_at"]."-".$time["ended_at"]
                ]);
                $tm->Doctor()->associate($dr);
                $tm->save();
            }
        }
    }
}
