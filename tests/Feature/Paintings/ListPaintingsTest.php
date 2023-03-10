<?php

namespace Tests\Feature\Paitings;

use App\Role;
use App\User;
use App\Painting;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListPaintingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_fetch_a_single_painting()
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
                        ])->getJson(route('api.v1.paintings.show', $painting));

        $response->assertExactJson([
            'data' => [
                'type' => 'paintings',
                'id' => $painting->getRouteKey(),
                'attributes' => [
                    'code'      => $painting->code,
                    'name'      => $painting->name,
                    'painter'   => $painting->painter,
                    'country'   => $painting->country,
                    'date'      => $painting->date,
                    'style'     => $painting->style,
                    'width'     => $painting->width,
                    'hight'     => $painting->hight
                ],
                'links' => [
                    'self' => route('api.v1.paintings.show', $painting)
                ]
            ]
        ]);
    }

    /** @test */
    public function can_fetch_all_paintings()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        $paintings = factory(Painting::class, 3)->create();

        $response = $this->withHeaders([
                            'X-HTTP-USER-ID' => $ruben->id
                        ])->getJson(route('api.v1.paintings.index'));

        $response->assertJson([
            'data' => [
                [
                    'type'  => 'paintings',
                    'id'    => $paintings[0]->getRouteKey(),
                    'attributes' => [
                        'code'      => $paintings[0]->code,
                        'name'      => $paintings[0]->name,
                        'painter'   => $paintings[0]->painter,
                        'country'   => $paintings[0]->country,
                        'date'      => $paintings[0]->date,
                        'style'     => $paintings[0]->style,
                        'width'     => $paintings[0]->width,
                        'hight'     => $paintings[0]->hight
                    ],
                    'links' => [
                        'self' => route('api.v1.paintings.show', $paintings[0])
                    ]
                ],
                [
                    'type'  => 'paintings',
                    'id'    => $paintings[1]->getRouteKey(),
                    'attributes' => [
                        'code'      => $paintings[1]->code,
                        'name'      => $paintings[1]->name,
                        'painter'   => $paintings[1]->painter,
                        'country'   => $paintings[1]->country,
                        'date'      => $paintings[1]->date,
                        'style'     => $paintings[1]->style,
                        'width'     => $paintings[1]->width,
                        'hight'     => $paintings[1]->hight
                    ],
                    'links' => [
                        'self' => route('api.v1.paintings.show', $paintings[1])
                    ]
                ],
                [
                    'type'  => 'paintings',
                    'id'    => $paintings[2]->getRouteKey(),
                    'attributes' => [
                        'code'      => $paintings[2]->code,
                        'name'      => $paintings[2]->name,
                        'painter'   => $paintings[2]->painter,
                        'country'   => $paintings[2]->country,
                        'date'      => $paintings[2]->date,
                        'style'     => $paintings[2]->style,
                        'width'     => $paintings[2]->width,
                        'hight'     => $paintings[2]->hight
                    ],
                    'links' => [
                        'self' => route('api.v1.paintings.show', $paintings[2])
                    ]
                ]
            ],
            'links' => [
                'self' => route('api.v1.paintings.index')
            ]
        ]);
    }
}
