<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Detail;
use App\Models\Image;
use App\Models\Listing;
use App\Models\Section;
use App\Models\Size;
use App\Models\Subsection;
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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        for($category= 0; $category < 3; $category++){
            $sections = Section::factory(rand(2,5)) -> for(Category::factory()) -> create();
            foreach($sections as $section){
                $subsections = Subsection::factory(3)-> create([
                    'section_id' => $section->getKey(),
                ]);
                foreach($subsections as $subsection){
                    $listings = Listing::factory(10) -> hasAttached($subsection) -> create();
                    foreach($listings as $listing){
                        Detail::factory(3) -> hasImages(2) -> create([
                            'listing_id' => $listing->getKey(),
                        ]);
                    }
                }
            }
        }
    }
}
