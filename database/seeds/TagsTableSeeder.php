<?php

use App\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->delete();

        Tag::create([
            'name' => 'sample',
            'color' => '#FFFFFF',
            'background_color' => '#3C96CB'
        ]);
    }
}
