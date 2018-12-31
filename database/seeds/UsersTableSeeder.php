<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'login_id' => 'admin',
            'name' => '管理者',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'role_id' => 3
        ]);

        /*$faker = Faker\Factory::create('ja_JP');
        for($i = 0; $i < 20; $i++) {
            User::create([
                'login_id' => $faker->userName(),
                'name' => $faker->name(),
                'email' => $faker->email(),
                'password' => Hash::make('test'),
                'role_id' => 1
            ]);
        }*/
    }
}
