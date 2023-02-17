<?php

namespace Tests\Feature\Users;

use App\Role;
use App\User;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_user()
    {
        $matias = factory(User::class)->create(['name' => 'Matias', 'email' => 'matias@gmail.com']);
        Role::create(['name' => 'EMPLOYEE']);
        $matias->assignRole("EMPLOYEE");

        Passport::actingAs(
            $matias,
            ['create-servers']
        );

        $response = $this->postJson(route('api.v1.users.store'), [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'name'      => 'David',
                    'email'     => 'david@gmail.com',
                    'password'  => 'password'
                ]
            ]
        ]);

        $response->assertCreated();

        $user = User::whereName('David')->first();

        $response->assertHeader(
            'Location',
            route('api.v1.users.show', $user)
        );

        $response->assertExactJson([
            'data' => [
                'type'  => 'users',
                'id'    => $user->getRouteKey(),
                'attributes' => [
                    'name'      => 'David',
                    'email'   => 'david@gmail.com'
                ],
                'links' => [
                    'self' => route('api.v1.users.show', $user)
                ]
            ]
        ]);
    }

    /** @test */
    public function name_is_required()
    {
        $matias = factory(User::class)->create(['name' => 'Matias', 'email' => 'matias@gmail.com']);
        Role::create(['name' => 'EMPLOYEE']);
        $matias->assignRole("EMPLOYEE");

        Passport::actingAs(
            $matias,
            ['create-servers']
        );

        $response = $this->postJson(route('api.v1.users.store'), [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'email'     => 'david@gmail.com',
                    'password'  => 'password'
                ]
            ]
        ]);

        $response->assertJsonValidationErrors('data.attributes.name');
    }

    /** @test */
    public function email_is_required()
    {
        $matias = factory(User::class)->create(['name' => 'Matias', 'email' => 'matias@gmail.com']);
        Role::create(['name' => 'EMPLOYEE']);
        $matias->assignRole("EMPLOYEE");

        Passport::actingAs(
            $matias,
            ['create-servers']
        );

        $response = $this->postJson(route('api.v1.users.store'), [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'name'      => 'David',
                    'password'  => 'password'
                ]
            ]
        ]);

        $response->assertJsonValidationErrors('data.attributes.email');
    }

    /** @test */
    public function password_is_required()
    {
        $matias = factory(User::class)->create(['name' => 'Matias', 'email' => 'matias@gmail.com']);
        Role::create(['name' => 'EMPLOYEE']);
        $matias->assignRole("EMPLOYEE");

        Passport::actingAs(
            $matias,
            ['create-servers']
        );

        $response = $this->postJson(route('api.v1.users.store'), [
            'data' => [
                'type' => 'users',
                'attributes' => [
                    'name'      => 'David',
                    'email'     => 'david@gmail.com'
                ]
            ]
        ]);

        $response->assertJsonValidationErrors('data.attributes.password');
    }
}
