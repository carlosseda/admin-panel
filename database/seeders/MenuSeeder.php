<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DB\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Menu::create([
            'name' => 'principal',
            'active' => 1
        ]);

    }
}
