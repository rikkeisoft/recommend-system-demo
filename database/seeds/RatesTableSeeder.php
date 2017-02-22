<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Model\User;
use App\Model\Book;
use App\Model\Rate;

class RatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker  = Faker::create();
        $users  = User::all()->pluck('id')->toArray();
        $books  = Book::all()->pluck('id')->toArray();
        $points = [1.00, 2.00, 3.00, 4.00, 5.00];

        for ($i = 0; $i < 100; $i++) {
            Rate::create([
                'user_id' => $faker->randomElement($users),
                'book_id' => $faker->randomElement($books),
                'point'   => $points[array_rand($points, 1)],
            ]);
        }
    }
}
