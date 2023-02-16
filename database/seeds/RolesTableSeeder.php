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
        $rolOwner = Role::create([
            'name' => 'OWNER',
        ]);

        $rolOwner->givePermissionTo(['VIEW PAINTINGS']);

        $rolEmployee = Role::create([
            'name' => 'EMPLOYEE',
        ]);

        $rolEmployee->givePermissionTo(['VIEW PAINTINGS']);

        $rolGuest = Role::create([
            'name' => 'GUEST',
        ]);
    }
}
