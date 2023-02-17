<?php

namespace Tests\Feature\Paintings;

use App\Role;
use App\User;
use App\Painting;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SortPaintingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_sort_paintings_by_name()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        factory(Painting::class)->create([
            'name' => 'C name'
        ]);

        factory(Painting::class)->create([
            'name' => 'A name'
        ]);

        factory(Painting::class)->create([
            'name' => 'B name'
        ]);

        $this->getJson(route('api.v1.paintings.index', ['sort' => 'name']))
                ->assertSeeInOrder([
                    'A name',
                    'B name',
                    'C name'
                ]);
    }

    /** @test */
    public function can_sort_paintings_by_name_descending()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        factory(Painting::class)->create([
            'name' => 'C name'
        ]);

        factory(Painting::class)->create([
            'name' => 'A name'
        ]);

        factory(Painting::class)->create([
            'name' => 'B name'
        ]);

        $this->getJson(route('api.v1.paintings.index', ['sort' => '-name']))
                ->assertSeeInOrder([
                    'C name',
                    'B name',
                    'A name'
                ]);
    }

    /** @test */
    public function can_sort_paintings_by_painter()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        factory(Painting::class)->create([
            'painter' => 'C painter'
        ]);

        factory(Painting::class)->create([
            'painter' => 'A painter'
        ]);

        factory(Painting::class)->create([
            'painter' => 'B painter'
        ]);

        $this->getJson(route('api.v1.paintings.index', ['sort' => 'painter']))
                ->assertSeeInOrder([
                    'A painter',
                    'B painter',
                    'C painter'
                ]);
    }

    /** @test */
    public function can_sort_paintings_by_painter_descending()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        factory(Painting::class)->create([
            'painter' => 'C painter'
        ]);

        factory(Painting::class)->create([
            'painter' => 'A painter'
        ]);

        factory(Painting::class)->create([
            'painter' => 'B painter'
        ]);

        $this->getJson(route('api.v1.paintings.index', ['sort' => '-painter']))
                ->assertSeeInOrder([
                    'C painter',
                    'B painter',
                    'A painter'
                ]);
    }

    /** @test */
    public function can_sort_paintings_by_country()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        factory(Painting::class)->create([
            'country' => 'C country'
        ]);

        factory(Painting::class)->create([
            'country' => 'A country'
        ]);

        factory(Painting::class)->create([
            'country' => 'B country'
        ]);

        $this->getJson(route('api.v1.paintings.index', ['sort' => 'country']))
                ->assertSeeInOrder([
                    'A country',
                    'B country',
                    'C country'
                ]);
    }

    /** @test */
    public function can_sort_paintings_by_country_descending()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        factory(Painting::class)->create([
            'country' => 'C country'
        ]);

        factory(Painting::class)->create([
            'country' => 'A country'
        ]);

        factory(Painting::class)->create([
            'country' => 'B country'
        ]);

        $this->getJson(route('api.v1.paintings.index', ['sort' => '-country']))
                ->assertSeeInOrder([
                    'C country',
                    'B country',
                    'A country'
                ]);
    }

    /** @test */
    public function can_sort_paintings_by_date()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        factory(Painting::class)->create([
            'date' => '2022-01-01'
        ]);

        factory(Painting::class)->create([
            'date' => '2019-01-01'
        ]);

        factory(Painting::class)->create([
            'date' => '2021-01-01'
        ]);

        $this->getJson(route('api.v1.paintings.index', ['sort' => 'date']))
                ->assertSeeInOrder([
                    '2019-01-01',
                    '2021-01-01',
                    '2022-01-01'
                ]);
    }

    /** @test */
    public function can_sort_paintings_by_date_descending()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        factory(Painting::class)->create([
            'date' => '2022-01-01'
        ]);

        factory(Painting::class)->create([
            'date' => '2019-01-01'
        ]);

        factory(Painting::class)->create([
            'date' => '2021-01-01'
        ]);

        $this->getJson(route('api.v1.paintings.index', ['sort' => '-date']))
                ->assertSeeInOrder([
                    '2022-01-01',
                    '2021-01-01',
                    '2019-01-01'
                ]);
    }

    /** @test */
    public function can_sort_paintings_by_style()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        factory(Painting::class)->create([
            'style' => 'C style'
        ]);

        factory(Painting::class)->create([
            'style' => 'A style'
        ]);

        factory(Painting::class)->create([
            'style' => 'B style'
        ]);

        $this->getJson(route('api.v1.paintings.index', ['sort' => 'style']))
                ->assertSeeInOrder([
                    'A style',
                    'B style',
                    'C style'
                ]);
    }

    /** @test */
    public function can_sort_paintings_by_style_descending()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        factory(Painting::class)->create([
            'style' => 'C style'
        ]);

        factory(Painting::class)->create([
            'style' => 'A style'
        ]);

        factory(Painting::class)->create([
            'style' => 'B style'
        ]);

        $this->getJson(route('api.v1.paintings.index', ['sort' => '-style']))
                ->assertSeeInOrder([
                    'C style',
                    'B style',
                    'A style'
                ]);
    }

    /** @test */
    public function can_sort_paintings_by_painter_and_style()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        factory(Painting::class)->create([
            'painter'   => 'A painter',
            'style'     => 'A style'
        ]);

        factory(Painting::class)->create([
            'painter'   => 'B painter',
            'style'     => 'B style'
        ]);

        factory(Painting::class)->create([
            'painter'   => 'A painter',
            'style'     => 'C style'
        ]);

        $this->getJson(route('api.v1.paintings.index', ['sort' => 'painter,-style']))
                ->assertSeeInOrder([
                    'C style',
                    'A style',
                    'B style'
                ]);
    }

    /** @test */
    public function cannot_sort_paintings_by_unallowed_fields()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        factory(Painting::class, 3)->create();

        $this->getJson(route('api.v1.paintings.index', ['sort' => 'code']))
                ->assertStatus(400);
    }
}
