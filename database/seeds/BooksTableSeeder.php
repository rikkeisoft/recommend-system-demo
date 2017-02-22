<?php

use App\Model\Book;
use App\Model\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker      = Faker::create();
        $categories = Category::all()->pluck('id')->toArray();
        $authors    = ['Nam Cao', 'Tố Hữu', 'Kim Lân', 'Hồ Chí Minh',
            'Aiflytomydr', 'Alex Sanderos', 'Michael Scofield', 'Lincoln Burrows'];

        for ($i = 0; $i < 50; $i++) {
            Book::create([
                'author'      => $authors[array_rand($authors, 1)],
                'title'       => $faker->text(100),
                'price'       => $faker->randomFloat(2, 10000, 1000000),
                'cover'       => 'images/cover' . rand(1, 14) . '.jpg',
                'category_id' => $faker->randomElement($categories),
                'views'       => rand(0, 1000),
            ]);
        }
    }
}
