<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = array('News','Economy','Sport','Culture','Health',
                            'Weather','Food','Vehicles','Environment','Science',
                            'Politics','Fashion','Technology','Lifestyle','Education' /*,
                            'Literature','Music','Business','Entertainment' */);
        foreach($categories as $cat)
        {
            Category::create(['name'=>$cat]);
        }
    }
}
