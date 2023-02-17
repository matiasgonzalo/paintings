<?php

namespace Tests\Feature\Paintings;

use App\Role;
use App\User;
use App\Painting;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePaintingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_update_paintings()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        $painting = factory(Painting::class)->create();

        $response = $this->withHeaders([
                        'X-HTTP-USER-ID' => $ruben->id
                    ])->patchJson(route('api.v1.paintings.update', $painting), [
                        'data' => [
                            'type' => 'paintings',
                            'attributes' => [
                                'code'      => 'codigo actualizado',
                                'name'      => 'nombre actualizado',
                                'painter'   => 'Monalisa',
                                'country'   => 'Argentina',
                                'date'      => '1993-01-01',
                                'style'     => 'Clasico',
                                'width'     => 1000,
                                'hight'     => 1000
                            ]
                        ]
                    ]);

        $response->assertOk();

        $painting = Painting::first();

        $response->assertHeader(
            'Location',
            route('api.v1.paintings.show', $painting)
        );

        $response->assertExactJson([
            'data' => [
                'type'  => 'paintings',
                'id'    => $painting->getRouteKey(),
                'attributes' => [
                    'code'      => 'codigo actualizado',
                    'name'      => 'nombre actualizado',
                    'painter'   => 'Monalisa',
                    'country'   => 'Argentina',
                    'date'      => '1993-01-01',
                    'style'     => 'Clasico',
                    'width'     => 1000,
                    'hight'     => 1000
                ],
                'links' => [
                    'self' => route('api.v1.paintings.show', $painting)
                ]
            ]
        ]);
    }

    /** @test */
    public function code_is_required()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        $painting = factory(Painting::class)->create();

        $response = $this->withHeaders([
                            'X-HTTP-USER-ID' => $ruben->id
                        ])->patchJson(route('api.v1.paintings.update', $painting), [
                            'data' => [
                                'type' => 'paintings',
                                'attributes' => [
                                    'name'      => 'Matias',
                                    'painter'   => 'Monalisa',
                                    'country'   => 'Argentina',
                                    'date'      => '1993-01-01',
                                    'style'     => 'Clasico',
                                    'width'     => 1000,
                                    'hight'     => 1000
                                ]
                            ]
                        ]);

        $response->assertJsonValidationErrors('data.attributes.code');
    }

    /** @test */
    public function name_is_required()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        $painting = factory(Painting::class)->create();

        $response = $this->withHeaders([
                            'X-HTTP-USER-ID' => $ruben->id
                        ])->patchJson(route('api.v1.paintings.update', $painting), [
                            'data' => [
                                'type' => 'paintings',
                                'attributes' => [
                                    'code'      => 'abcdefghijk12345',
                                    'painter'   => 'Monalisa',
                                    'country'   => 'Argentina',
                                    'date'      => '1993-01-01',
                                    'style'     => 'Clasico',
                                    'width'     => 1000,
                                    'hight'     => 1000
                                ]
                            ]
                        ]);

        $response->assertJsonValidationErrors('data.attributes.name');
    }

    /** @test */
    public function painter_is_required()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        $painting = factory(Painting::class)->create();

        $response = $this->withHeaders([
                            'X-HTTP-USER-ID' => $ruben->id
                        ])->patchJson(route('api.v1.paintings.update', $painting), [
                            'data' => [
                                'type' => 'paintings',
                                'attributes' => [
                                    'code'      => 'abcdefghijk12345',
                                    'name'      => 'Matias',
                                    'country'   => 'Argentina',
                                    'date'      => '1993-01-01',
                                    'style'     => 'Clasico',
                                    'width'     => 1000,
                                    'hight'     => 1000
                                ]
                            ]
                        ]);

        $response->assertJsonValidationErrors('data.attributes.painter');
    }

    /** @test */
    public function country_is_required()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        $painting = factory(Painting::class)->create();

        $response = $this->withHeaders([
                            'X-HTTP-USER-ID' => $ruben->id
                        ])->patchJson(route('api.v1.paintings.update', $painting), [
                            'data' => [
                                'type' => 'paintings',
                                'attributes' => [
                                    'code'      => 'abcdefghijk12345',
                                    'name'      => 'Matias',
                                    'painter'   => 'Monalisa',
                                    'date'      => '1993-01-01',
                                    'style'     => 'Clasico',
                                    'width'     => 1000,
                                    'hight'     => 1000
                                ]
                            ]
                        ]);

        $response->assertJsonValidationErrors('data.attributes.country');
    }

    /** @test */
    public function date_is_required()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        $painting = factory(Painting::class)->create();

        $response = $this->withHeaders([
                            'X-HTTP-USER-ID' => $ruben->id
                        ])->patchJson(route('api.v1.paintings.update', $painting), [
                            'data' => [
                                'type' => 'paintings',
                                'attributes' => [
                                    'code'      => 'abcdefghijk12345',
                                    'name'      => 'Matias',
                                    'country'   => 'Argentina',
                                    'painter'   => 'Monalisa',
                                    'style'     => 'Clasico',
                                    'width'     => 1000,
                                    'hight'     => 1000
                                ]
                            ]
                        ]);

        $response->assertJsonValidationErrors('data.attributes.date');
    }

    /** @test */
    public function style_is_required()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        $painting = factory(Painting::class)->create();

        $response = $this->withHeaders([
                            'X-HTTP-USER-ID' => $ruben->id
                        ])->patchJson(route('api.v1.paintings.update', $painting), [
                            'data' => [
                                'type' => 'paintings',
                                'attributes' => [
                                    'code'      => 'abcdefghijk12345',
                                    'name'      => 'Matias',
                                    'country'   => 'Argentina',
                                    'painter'   => 'Monalisa',
                                    'date'      => '1993-01-01',
                                    'width'     => 1000,
                                    'hight'     => 1000
                                ]
                            ]
                        ]);

        $response->assertJsonValidationErrors('data.attributes.style');
    }

    /** @test */
    public function width_is_required()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        $painting = factory(Painting::class)->create();

        $response = $this->withHeaders([
                            'X-HTTP-USER-ID' => $ruben->id
                        ])->patchJson(route('api.v1.paintings.update', $painting), [
                            'data' => [
                                'type' => 'paintings',
                                'attributes' => [
                                    'code'      => 'abcdefghijk12345',
                                    'name'      => 'Matias',
                                    'country'   => 'Argentina',
                                    'painter'   => 'Monalisa',
                                    'date'      => '1993-01-01',
                                    'style'     => 'Clasico',
                                    'hight'     => 1000
                                ]
                            ]
                        ]);

        $response->assertJsonValidationErrors('data.attributes.width');
    }

    /** @test */
    public function hight_is_required()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        $painting = factory(Painting::class)->create();

        $response = $this->withHeaders([
                            'X-HTTP-USER-ID' => $ruben->id
                        ])->patchJson(route('api.v1.paintings.update', $painting), [
                            'data' => [
                                'type' => 'paintings',
                                'attributes' => [
                                    'code'      => 'abcdefghijk12345',
                                    'name'      => 'Matias',
                                    'country'   => 'Argentina',
                                    'painter'   => 'Monalisa',
                                    'date'      => '1993-01-01',
                                    'style'     => 'Clasico',
                                    'width'     => 1000
                                ]
                            ]
                        ]);

        $response->assertJsonValidationErrors('data.attributes.hight');
    }
}
