<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->delete();

        Status::create(['name' => '-']);
        Status::create(['name' => '未完了']);
        Status::create(['name' => '継続']);
        Status::create(['name' => '保留']);
        Status::create(['name' => '完了']);
    }
}
