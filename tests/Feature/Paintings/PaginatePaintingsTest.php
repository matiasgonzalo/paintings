<?php

namespace Tests\Feature\Paintings;

use App\Role;
use App\User;
use App\Painting;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaginatePaintingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_paginate_paintings()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        $paintings = factory(Painting::class, 6)->create();

        // paintings?page[size]=2&page[number]=2
        $response = $this->getJson(route('api.v1.paintings.index', [
            'page' => [
                'size' => 2,
                'number' => 2
            ]
        ]));

        $response->assertSee(
            $paintings[2]->name,
            $paintings[3]->name
        );

        $response->assertDontSee(
            $paintings[0]->name,
            $paintings[1]->name,
            $paintings[4]->name,
            $paintings[5]->name
        );

        $response->assertJsonStructure([
            'links' => ['first', 'last', 'prev', 'next']
        ]);

        $firstLink = urldecode($response->json('links.first'));

        $this->assertStringContainsString('page[number]=1', $firstLink);
        $this->assertStringContainsString('page[size]=2', $firstLink);
    }
}
