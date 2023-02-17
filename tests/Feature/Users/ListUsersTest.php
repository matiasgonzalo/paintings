<?php

namespace Tests\Feature\Users;

use App\Role;
use App\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_a_single_user()
    {
        $matias = factory(User::class)->create(['name' => 'Matias', 'email' => 'matias@gmail.com']);
        Role::create(['name' => 'EMPLOYEE']);
        $matias->assignRole("EMPLOYEE");

        Passport::actingAs(
            $matias,
            ['create-servers']
        );

        $user = factory(User::class)->create();

        $response = $this->getJson(route('api.v1.users.show', $user));

        $response->assertJson([
            'data' => [
                'type' => 'users',
                'id' => $user->getRouteKey(),
                'attributes' => [
                    'name'      => $user->name,
                    'email'     => $user->email
                ],
                'links' => [
                    'self' => route('api.v1.users.show', $user)
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_users()
    {
        $matias = factory(User::class)->create(['name' => 'Matias', 'email' => 'matias@gmail.com']);
        Role::create(['name' => 'EMPLOYEE']);
        $matias->assignRole("EMPLOYEE");

        Passport::actingAs(
            $matias,
            ['create-servers']
        );

        factory(User::class, 3)->create();

        $users = User::all();

        $response = $this->getJson(route('api.v1.users.index'));

        $response->assertJson([
            'data' => [
                [
                    'type'  => 'users',
                    'id'    => $users[0]->getRouteKey(),
                    'attributes' => [
                        'name'      => $users[0]->name,
                        'email'     => $users[0]->email
                    ],
                    'links' => [
                        'self' => route('api.v1.users.show', $users[0])
                    ]
                ],
                [
                    'type'  => 'users',
                    'id'    => $users[1]->getRouteKey(),
                    'attributes' => [
                        'name'      => $users[1]->name,
                        'email'     => $users[1]->email
                    ],
                    'links' => [
                        'self' => route('api.v1.users.show', $users[1])
                    ]
                ],
                [
                    'type'  => 'users',
                    'id'    => $users[2]->getRouteKey(),
                    'attributes' => [
                        'name'      => $users[2]->name,
                        'email'     => $users[2]->email
                    ],
                    'links' => [
                        'self' => route('api.v1.users.show', $users[2])
                    ]
                ]
            ],
            'links' => [
                'self' => route('api.v1.users.index')
            ]
        ]);
    }
}
