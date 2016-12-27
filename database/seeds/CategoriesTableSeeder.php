<?php

use Illuminate\Database\Seeder;
use App\Model\Category;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Truyện', 'Thơ', 'Ngôn tình', 'Toán', 'Địa lý', 'Lịch sử'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }

}
