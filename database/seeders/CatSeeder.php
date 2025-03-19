<?php

namespace Database\Seeders;

use App\Models\Cat;
use Illuminate\Database\Seeder;

class CatSeeder extends Seeder
{
    public function run()
    {
        $cats = Cat::factory()->count(100)->create();

        $females = $cats->where('gender', 'female');
        $males   = $cats->where('gender', 'male');

        foreach ($cats as $cat) {
            // if cats age lesser that two it gets mother
            if ($cat->age <= 2 && $females->isNotEmpty()) {
                $cat->mother_id = $females->random()->id;
            }

            $cat->save();

            if ($males->isNotEmpty()) {
                $possibleFathers = $males->filter(fn($m) => $m->age > $cat->age);
                $fatherCount = min(rand(0, 3), $possibleFathers->count());
                if ($fatherCount > 0) {
                    $cat->fathers()->attach(
                        $possibleFathers->random($fatherCount)->pluck('id')->toArray()
                    );
                }
            }
        }
    }
}
