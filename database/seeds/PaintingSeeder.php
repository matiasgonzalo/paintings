<?php

use App\Painting;
use Illuminate\Database\Seeder;

class PaintingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Painting::class, 20)->create();
    }
}
