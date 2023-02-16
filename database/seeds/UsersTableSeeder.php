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
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        $ruben->assignRole("OWNER");

        $matias = factory(User::class)->create(['name' => 'Matias', 'email' => 'matias@gmail.com']);
        $matias->assignRole("EMPLOYEE");

        $gonzalo = factory(User::class)->create(['name' => 'Gonzalo', 'email' => 'gonzalo@gmail.com']);
        $gonzalo->assignRole("EMPLOYEE");
    }
}
