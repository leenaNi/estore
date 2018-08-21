<?php

use Illuminate\Database\Seeder;
use App\Models\StaticPage;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	StaticPage::truncate();
		StaticPage::create([
			'page_name' => 'About Us',
			'status' => '1'
		]);	
    	
        StaticPage::create([
            'page_name' => 'T&C',
            'status' => '1'
        ]);
    }
}
