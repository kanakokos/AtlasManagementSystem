<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['id' => '1',
            'over_name' => '麻生',
            'under_name' => '花子',
            'over_name_kana' => 'アソウ',
            'under_name_kana' => 'ハナコ',
            'mail_address' => 'a@gmail.com',
            'sex' => '2',
            'birth_day' => '2000-01-01',
            'role' => '1',
            'password' => Hash::make('00001111'),]
        ]);

    }
}
