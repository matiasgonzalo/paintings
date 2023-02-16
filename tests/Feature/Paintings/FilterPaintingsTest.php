<?php

namespace Tests\Feature\Paintings;

use App\Painting;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FilterPaintingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_filter_paintings_by_name()
    {
        factory(Painting::class)->create([
            'name' => 'My painting'
        ]);

        factory(Painting::class)->create([
            'name' => 'Other painting'
        ]);

        // paintings?filter[name]=My
        $response = $this->getJson(route('api.v1.paintings.index', [
                                'filter' => [
                                    'name' => 'My'
                                ]
                            ]));
        $response->assertJsonCount(1, 'data');

        $response->assertSee('My');

        $response->assertDontSee('Other painting');
    }

    /** @test */
    public function can_filter_paintings_by_painter()
    {
        factory(Painting::class)->create([
            'painter' => 'Matias'
        ]);

        factory(Painting::class)->create([
            'painter' => 'Other painter'
        ]);

        // paintings?filter[painter]=Matias
        $response = $this->getJson(route('api.v1.paintings.index', [
                                'filter' => [
                                    'painter' => 'Matias'
                                ]
                            ]));
        $response->assertJsonCount(1, 'data');

        $response->assertSee('Matias');

        $response->assertDontSee('Other painter');
    }

    /** @test */
    public function can_filter_paintings_by_year()
    {
        factory(Painting::class)->create([
            'date' => '2023-01-01'
        ]);

        factory(Painting::class)->create([
            'date' => '2022-01-01'
        ]);

        // paintings?filter[month]=2022
        $response = $this->getJson(route('api.v1.paintings.index', [
                                'filter' => [
                                    'year' => 2022
                                ]
                            ]));
        $response->assertJsonCount(1, 'data');

        $response->assertSee('2022');

        $response->assertDontSee('2023');
    }

    /** @test */
    public function can_filter_paintings_by_month()
    {
        factory(Painting::class)->create([
            'date' => '2023-05-01'
        ]);

        factory(Painting::class)->create([
            'date' => '2022-07-01'
        ]);

        // paintings?filter[month]=07
        $response = $this->getJson(route('api.v1.paintings.index', [
                                'filter' => [
                                    'month' => 07
                                ]
                            ]));
        $response->assertJsonCount(1, 'data');

        $response->assertSee('07');

        $response->assertDontSee('05');
    }

    /** @test */
    public function can_filter_paintings_by_day()
    {
        factory(Painting::class)->create([
            'date' => '2023-01-28'
        ]);

        factory(Painting::class)->create([
            'date' => '2022-01-25'
        ]);

        // paintings?filter[day]=25
        $response = $this->getJson(route('api.v1.paintings.index', [
                                'filter' => [
                                    'day' => 25
                                ]
                            ]));
        $response->assertJsonCount(1, 'data');

        $response->assertSee('25');

        $response->assertDontSee('28');
    }

    /** @test */
    public function can_filter_paintings_by_date()
    {
        factory(Painting::class)->create([
            'date' => '2023-01-01'
        ]);

        factory(Painting::class)->create([
            'date' => '2022-01-01'
        ]);

        // paintings?filter[date]=2022-01-01
        $response = $this->getJson(route('api.v1.paintings.index', [
                                'filter' => [
                                    'date' => '2022-01-01'
                                ]
                            ]));
        $response->assertJsonCount(1, 'data');

        $response->assertSee('2022-01-01');

        $response->assertDontSee('2023-01-01');
    }

    /** @test */
    public function can_filter_paintings_by_country()
    {
        factory(Painting::class)->create([
            'country' => 'Argentina'
        ]);

        factory(Painting::class)->create([
            'country' => 'Paraguay'
        ]);

        // paintings?filter[country]=Argentina
        $response = $this->getJson(route('api.v1.paintings.index', [
                                'filter' => [
                                    'country' => 'Argentina'
                                ]
                            ]));
        $response->assertJsonCount(1, 'data');

        $response->assertSee('Argentina');

        $response->assertDontSee('Paraguay');
    }

    /** @test */
    public function can_filter_paintings_by_style()
    {
        factory(Painting::class)->create([
            'style' => 'Clasico'
        ]);

        factory(Painting::class)->create([
            'style' => 'Moderno'
        ]);

        // paintings?filter[style]=Clasico
        $response = $this->getJson(route('api.v1.paintings.index', [
                                'filter' => [
                                    'style' => 'Clasico'
                                ]
                            ]));
        $response->assertJsonCount(1, 'data');

        $response->assertSee('Clasico');

        $response->assertDontSee('Moderno');
    }

    /** @test */
    public function can_filter_paintings_by_width()
    {
        factory(Painting::class)->create([
            'width' => 1500
        ]);

        factory(Painting::class)->create([
            'width' => 2500
        ]);

        // paintings?filter[width]=1500
        $response = $this->getJson(route('api.v1.paintings.index', [
                                'filter' => [
                                    'width' => 1500
                                ]
                            ]));
        $response->assertJsonCount(1, 'data');

        $response->assertSee('1500');

        $response->assertDontSee('2500');
    }

    /** @test */
    public function can_filter_paintings_by_hight()
    {
        factory(Painting::class)->create([
            'hight' => 3000
        ]);

        factory(Painting::class)->create([
            'hight' => 3500
        ]);

        // paintings?filter[hight]=3500
        $response = $this->getJson(route('api.v1.paintings.index', [
                                'filter' => [
                                    'hight' => 3500
                                ]
                            ]));
        $response->assertJsonCount(1, 'data');

        $response->assertSee('3500');

        $response->assertDontSee('3000');
    }

    /** @test */
    public function cannot_filter_paintings_by_unknown_filters()
    {
        factory(Painting::class, 2)->create();

        // paintings?filter[unknown]=unknown
        $response = $this->getJson(route('api.v1.paintings.index', [
                                'filter' => [
                                    'unknown' => 'unknown'
                                ]
                            ]));
        $response->assertStatus(400);
    }
}
