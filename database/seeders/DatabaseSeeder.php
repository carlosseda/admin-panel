<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(FaqCategorySeeder::class);
    }
}
