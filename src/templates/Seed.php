<?php

use Illuminate\Database\Seeder;

class {template}TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Http\Models\{template}::class,2)->create();
    }
}
