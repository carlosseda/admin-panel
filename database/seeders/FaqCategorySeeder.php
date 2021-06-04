<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DB\FaqCategory;

class FaqCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        FaqCategory::create([
            'name' => 'general',
            'active' => 1
        ]);

    }
}
