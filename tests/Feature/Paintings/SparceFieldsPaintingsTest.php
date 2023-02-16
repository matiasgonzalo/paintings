<?php

namespace Tests\Feature\Paintings;

use App\Painting;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SparceFieldsPaintingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function specific_fields_can_be_requested()
    {
        $painting = factory(Painting::class)->create();

        //paintings?fields[paintings]=name,painter
        $response = $this->getJson(route('api.v1.paintings.index', [
            'fields' => [
                'paintings' => 'name,painter'
            ]
        ]));

        $response->assertJsonFragment([
            'name' => $painting->name,
            'painter' => $painting->painter
        ]);

        $response->assertJsonMissing([
            'date' => $painting->date,
            'style' => $painting->style,
            'code' => $painting->code,
            'width' => $painting->width,
            'hight' => $painting->hight
        ]);

        $response->assertJsonMissing([
            'date' => null,
            'style' => null,
            'code' => null,
            'width' => null,
            'hight' => null
        ]);
    }
}