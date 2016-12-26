<?php

use App\Model\Book;
use App\Model\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::pluck('id')->toArray();
        $authors = ['Nam Cao', 'Tố Hữu', 'Kim Lân', 'Hồ Chí Minh', 'Aiflytomydr'];
        $covers = ['images/demo1.jpg', 'images/demo2.jpg'];

        for ($i = 0; $i < 20; $i++) {
            $title = Str::random('5') . ' ' . Str::random('5') . ' ' .
                Str::random('5') . ' ' . Str::random('5') . ' ';

            Book::create([
                'author' => $authors[array_rand($authors, 1)],
                'title' => $title,
                'price' => rand(10000, 1000000),
                'cover' => $covers[array_rand($covers, 1)],
                'category_id' => $categories[array_rand($categories, 1)],
            ]);
        }
    }
}
