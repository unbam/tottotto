<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        Role::create([
            'name' => '一般',
            'level' => 1
        ]);

        Role::create([
            'name' => '運用管理者',
            'level' => 10
        ]);

        Role::create([
            'name' => 'システム管理者',
            'level' => 100
        ]);
    }
}
