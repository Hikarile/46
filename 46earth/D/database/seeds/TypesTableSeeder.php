<?php

use Illuminate\Database\Seeder;
//use App\Models\types;
use App\Models\ones;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // types::create([
			// 'type'=>'test',
			// 'car'=>123,
			// 'singlecar'=>123,
			// 'total'=>123
		// ]);
        ones::create([
			'ac'=>'test',
			'ps'=>'5678',
		]);
    }
}
