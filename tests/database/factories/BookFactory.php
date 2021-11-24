<?php

namespace Matteomeloni\LaravelRestQl\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Matteomeloni\LaravelRestQl\Tests\Book;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       return [
           'title' => $this->faker->sentence(3),
           'description' => $this->faker->sentence(10),
           'author' => $this->faker->name,
           'category_id' => $this->faker->randomNumber()
       ];
    }
}
