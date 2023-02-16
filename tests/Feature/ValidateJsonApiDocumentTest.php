<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Middleware\ValidateJsonApiDocument;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidateJsonApiDocumentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::any('test_route', fn() => 'OK')
            ->middleware(ValidateJsonApiDocument::class);
    }

    /** @test */
    public function data_is_required()
    {
        $this->postJson('test_route', [])
            ->assertJsonValidationErrors('data');

        $this->patchJson('test_route', [])
            ->assertJsonValidationErrors('data');

        $this->putJson('test_route', [])
            ->assertJsonValidationErrors('data');
    }

    /** @test */
    public function data_must_be_an_array()
    {
        $this->postJson('test_route', [
            'data' => 'string'
        ])->assertJsonValidationErrors('data');

        $this->patchJson('test_route', [
            'data' => 'string'
        ])->assertJsonValidationErrors('data');

        $this->putJson('test_route', [
            'data' => 'string'
        ])->assertJsonValidationErrors('data');
    }

    /** @test */
    public function data_type_is_required()
    {
        $this->postJson('test_route', [
            'data' => [
                'attributes' => []
            ]
        ])->assertJsonValidationErrors('data.type');

        $this->patchJson('test_route', [
            'data' => [
                'attributes' => []
            ]
        ])->assertJsonValidationErrors('data.type');

        $this->putJson('test_route', [
            'data' => [
                'attributes' => []
            ]
        ])->assertJsonValidationErrors('data.type');
    }

    /** @test */
    public function data_type_must_be_an_string()
    {
        $this->postJson('test_route', [
            'data' => [
                'attributes' => [],
                'type' => 1
            ]
        ])->assertJsonValidationErrors('data.type');

        $this->patchJson('test_route', [
            'data' => [
                'attributes' => [],
                'type' => 1
            ]
        ])->assertJsonValidationErrors('data.type');

        $this->putJson('test_route', [
            'data' => [
                'attributes' => [],
                'type' => 1
            ]
        ])->assertJsonValidationErrors('data.type');
    }

    /** @test */
    public function data_attributes_is_required()
    {
        $this->postJson('test_route', [
            'data' => [
                'type' => 'painting'
            ]
        ])->assertJsonValidationErrors('data.attributes');

        $this->patchJson('test_route', [
            'data' => [
                'type' => 'painting'
            ]
        ])->assertJsonValidationErrors('data.attributes');

        $this->putJson('test_route', [
            'data' => [
                'type' => 'painting'
            ]
        ])->assertJsonValidationErrors('data.attributes');
    }

    /** @test */
    public function data_attributes_must_be_an_array()
    {
        $this->postJson('test_route', [
            'data' => [
                'attributes' => 'string',
                'type' => 'painting'
            ]
        ])->assertJsonValidationErrors('data.attributes');

        $this->patchJson('test_route', [
            'data' => [
                'attributes' => 'string',
                'type' => 'painting'
            ]
        ])->assertJsonValidationErrors('data.attributes');

        $this->putJson('test_route', [
            'data' => [
                'attributes' => 'string',
                'type' => 'painting'
            ]
        ])->assertJsonValidationErrors('data.attributes');
    }
}
