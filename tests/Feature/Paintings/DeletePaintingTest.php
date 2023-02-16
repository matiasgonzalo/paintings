<?php

namespace Tests\Feature\Paintings;

use App\Painting;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletePaintingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_delete_paintings()
    {
        $painting = factory(Painting::class)->create();

        $this->deleteJson(route('api.v1.paintings.destroy', $painting))
            ->assertNoContent();

        $this->assertDeleted($painting);
    }
}
