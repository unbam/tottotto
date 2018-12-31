<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();

        Category::create(['name' => 'なし']);
        Category::create(['name' => '開発']);
        Category::create(['name' => '導入']);
        Category::create(['name' => '営業']);
    }
}
