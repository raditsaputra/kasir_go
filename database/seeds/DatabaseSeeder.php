<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email'=> 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make ('sasak123'),
            'role' => 'admin'
           ],
        );

        DB::table('users')->insert([
            'name' => 'kasir',
            'email'=> 'kasir@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make ('sasak123'),
            'role' => 'kasir'
           ],
        );

        DB::table('users')->insert([
            'name' => 'Adam',
            'email'=> 'adam@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make ('sasak123'),
            'role' => 'kasir'
           ],
        );
    }

    
}
