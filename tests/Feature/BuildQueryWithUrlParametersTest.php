<?php

namespace Feature;

use Matteomeloni\LaravelRestQl\Tests\Book;
use Matteomeloni\LaravelRestQl\Tests\TestCase;

class BuildQueryWithUrlParametersTest extends TestCase
{
    /** @test */
    public function choose_columns()
    {
        Book::factory()->create([
            'title' => 'Lorem Ipsum'
        ]);

        $this->get('api/books?select=["title"]')
            ->assertJsonFragment(['title' => 'Lorem Ipsum']);
    }

    /** @test */
    public function search_string()
    {
        $book = Book::factory()->create(['title' => 'NewTitle']);
        Book::factory(4)->create();

        $this->get('api/books?search=NewTitle')
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'title' => $book->title,
                'description' => $book->description,
                'author' => $book->author,
                'category_id' => $book->category_id,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at,
            ]);
    }

    /** @test */
    public function set_query_with_equal_operator()
    {
        Book::factory()->create(['title' => 'New Title']);
        Book::factory(4)->create();

        $filters = [
            ['column' => 'title', 'operator' => '=', 'value' => 'New Title']
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(1);
    }

    /** @test */
    public function set_query_with_not_equal_operator()
    {
        Book::factory()->create(['title' => 'New Title']);
        Book::factory(4)->create();

        $filters = [
            ['column' => 'title', 'operator' => '!=', 'value' => 'New Title']
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(4);
    }

    /** @test */
    public function set_query_with_greater_than_operator()
    {
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $filters = [
            ['column' => 'category_id', 'operator' => '>', 'value' => 3]
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(2);

        $filters = [
            ['column' => 'category_id', 'operator' => '>=', 'value' => 3]
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(3);
    }

    /** @test */
    public function set_query_with_less_than_operator()
    {
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $filters = [
            ['column' => 'category_id', 'operator' => '<', 'value' => 3]
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(2);

        $filters = [
            ['column' => 'category_id', 'operator' => '<=', 'value' => 3]
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(3);
    }

    /** @test */
    public function set_query_with_like_operator()
    {
        Book::factory()->create(['title' => 'New Title']);
        Book::factory(4)->create();

        $filters = [
            ['column' => 'title', 'operator' => 'like', 'value' => 'New Title']
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(1);
    }

    /** @test */
    public function set_query_with_not_like_operator()
    {
        Book::factory()->create(['title' => 'New Title']);
        Book::factory(4)->create();

        $filters = [
            ['column' => 'title', 'operator' => 'not like', 'value' => 'New Title']
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(4);
    }

    /** @test */
    public function set_query_with_in_operator()
    {
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $filters = [
            ['column' => 'category_id', 'operator' => 'in', 'value' => [2, 4]]
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(2);
    }

    /** @test */
    public function set_query_with_not_in_operator()
    {
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $filters = [
            ['column' => 'category_id', 'operator' => 'not in', 'value' => [2, 4]]
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(3);
    }

    /** @test */
    public function set_query_with_between_operator()
    {
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $filters = [
            ['column' => 'category_id', 'operator' => 'between', 'value' => [2, 4]]
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(3);
    }

    /** @test */
    public function set_query_with_not_between_operator()
    {
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $filters = [
            ['column' => 'category_id', 'operator' => 'not between', 'value' => [2, 4]]
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(2);
    }

    /** @test */
    public function set_query_with_null_operator()
    {
        Book::factory()->create(['description' => null]);
        Book::factory(4)->create();

        $filters = [
            ['column' => 'description', 'operator' => 'null']
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(1);
    }

    /** @test */
    public function set_query_with_multiple_conditions()
    {
        Book::factory()->create(['title' => 'New Title', 'category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $filters = [
            ['column' => 'title', 'operator' => '=', 'value' => 'New Title'],
            ['column' => 'category_id', 'operator' => '=', 'value' => 1]
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(1);
    }

    /** @test */
    public function set_query_with_multiple_or_logic_conditions()
    {
        Book::factory()->create(['title' => 'New Title', 'category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $filters = [
            ['column' => 'title', 'operator' => '=', 'value' => 'New Title'],
            ['column' => 'category_id', 'operator' => '=', 'value' => 2, 'boolean' => 'or']
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(2);
    }

    /** @test */
    public function set_query_with_grouped_conditions()
    {
        Book::factory()->create(['title' => 'New Title', 'category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $filters = [
            ['column' => 'title', 'operator' => '=', 'value' => 'New Title'],
            [
                ['column' => 'category_id', 'operator' => '=', 'value' => 1],
                ['column' => 'category_id', 'operator' => '=', 'value' => 5, 'boolean' => 'or']
            ]
        ];

        $this->get('api/books?filters=' . json_encode($filters))
            ->assertJsonCount(1);
    }

    /** @test */
    public function sort_ascending_results()
    {
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 5]);

        $sorts = [
            ['column' => 'category_id'],
        ];

        $response = $this->get('api/books?sorts=' . json_encode($sorts))
            ->json();

        $this->assertTrue($response[0]['category_id'] === 1);
    }

    /** @test */
    public function sort_descending_results()
    {
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 5]);

        $sorts = [
            ['column' => 'category_id', 'direction' => 'desc'],
        ];

        $response = $this->get('api/books?sorts=' . json_encode($sorts))
            ->json();

        $this->assertTrue($response[0]['category_id'] === 5);
    }
}
