<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = array('News','Economy','Sport','Culture','Health','Weather','Food','Vehicles','Environment','Science','Parenting','Fashion','Vacations');
        foreach($categories as $cat)
        {
            Category::create(['name'=>$cat]);
        }

        //Category::factory(30)->create();
        // User::factory(10)->create();


       /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */
    }
}
