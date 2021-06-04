<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Vendor\Locale\Models\LocaleLanguage;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        LocaleLanguage::create([
            'name' => 'Español',
            'alias' => 'es',
            'default' => 1,
            'active' => 1
        ]);
    }
}
