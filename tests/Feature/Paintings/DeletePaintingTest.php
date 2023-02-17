<?php

namespace Tests\Feature\Paintings;

use App\Role;
use App\User;
use App\Painting;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletePaintingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_delete_paintings()
    {
        $ruben = factory(User::class)->create(['name' => 'Ruben', 'email' => 'ruben@gmail.com']);
        Role::create(['name' => 'OWNER']);
        $ruben->assignRole("OWNER");

        Passport::actingAs(
            $ruben,
            ['create-servers']
        );

        $painting = factory(Painting::class)->create();

        $this->deleteJson(route('api.v1.paintings.destroy', $painting))
            ->assertNoContent();

        $this->assertDeleted($painting);
    }
}
