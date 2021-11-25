<?php

namespace Feature;

use Matteomeloni\LaravelRestQl\Tests\Book;
use Matteomeloni\LaravelRestQl\Tests\TestCase;

class BuildQueryWithArrayTest extends TestCase
{
    /** @test */
    public function choose_columns()
    {
        Book::factory()->create([
            'title' => 'Lorem Ipsum'
        ]);

        $data = ['columns' => ['title']];

        $books = Book::restQl($data)->get();

        $this->assertEquals(['title' => 'Lorem Ipsum'], $books->first()->toArray());
        $this->assertNotContains('description', $books->first()->toArray());
    }

    /** @test */
    public function search_string()
    {
        Book::factory()->create(['title' => 'New Title']);
        Book::factory(4)->create();

        $this->assertCount(5, Book::all());

        $data = ['search' => 'New Title'];

        $books = Book::restQl($data)->get();

        $this->assertCount(1, $books);
    }

    /** @test */
    public function set_query_with_equal_operator()
    {
        Book::factory()->create(['title' => 'New Title']);
        Book::factory(4)->create();

        $queryString = 'select * from "books_tests" where "title" = ?';
        $data = [
            'filters' => [
                ['column' => 'title', 'operator' => '=', 'value' => 'New Title']
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(1, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function set_query_with_not_equal_operator()
    {
        Book::factory()->create(['title' => 'New Title']);
        Book::factory(4)->create();

        $queryString = 'select * from "books_tests" where "title" != ?';
        $data = [
            'filters' => [
                ['column' => 'title', 'operator' => '!=', 'value' => 'New Title']
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(4, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function set_query_with_greater_than_operator()
    {
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $queryString = 'select * from "books_tests" where "category_id" > ?';
        $data = [
            'filters' => [
                ['column' => 'category_id', 'operator' => '>', 'value' => 3]
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(2, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());

        $queryString = 'select * from "books_tests" where "category_id" >= ?';
        $data = [
            'filters' => [
                ['column' => 'category_id', 'operator' => '>=', 'value' => 3]
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(3, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function set_query_with_less_than_operator()
    {
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $queryString = 'select * from "books_tests" where "category_id" < ?';
        $data = [
            'filters' => [
                ['column' => 'category_id', 'operator' => '<', 'value' => 3]
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(2, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());

        $queryString = 'select * from "books_tests" where "category_id" <= ?';
        $data = [
            'filters' => [
                ['column' => 'category_id', 'operator' => '<=', 'value' => 3]
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(3, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function set_query_with_like_operator()
    {
        Book::factory()->create(['title' => 'New Title']);
        Book::factory(4)->create();

        $queryString = 'select * from "books_tests" where "title" like ?';
        $data = [
            'filters' => [
                ['column' => 'title', 'operator' => 'like', 'value' => 'New Title']
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(1, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function set_query_with_not_like_operator()
    {
        Book::factory()->create(['title' => 'NewTitle']);
        Book::factory(4)->create();

        $queryString = 'select * from "books_tests" where "title" not like ?';
        $data = [
            'filters' => [
                ['column' => 'title', 'operator' => 'not like', 'value' => 'NewTitle']
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(4, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function set_query_with_in_operator()
    {
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $queryString = 'select * from "books_tests" where "category_id" in (?, ?)';
        $data = [
            'filters' => [
                ['column' => 'category_id', 'operator' => 'in', 'value' => [2, 4]]
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(2, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function set_query_with_not_in_operator()
    {
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $queryString = 'select * from "books_tests" where "category_id" not in (?, ?)';
        $data = [
            'filters' => [
                ['column' => 'category_id', 'operator' => 'not in', 'value' => [2, 4]]
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(3, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function set_query_with_between_operator()
    {
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $queryString = 'select * from "books_tests" where "category_id" between ? and ?';
        $data = [
            'filters' => [
                ['column' => 'category_id', 'operator' => 'between', 'value' => [2, 4]]
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(3, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function set_query_with_multiple_conditions()
    {
        Book::factory()->create(['title' => 'New Title', 'category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $queryString = 'select * from "books_tests" where "title" = ? and "category_id" = ?';
        $data = [
            'filters' => [
                ['column' => 'title', 'operator' => '=', 'value' => 'New Title'],
                ['column' => 'category_id', 'operator' => '=', 'value' => 1]
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(1, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function set_query_with_multiple_or_logic_conditions()
    {
        Book::factory()->create(['title' => 'New Title', 'category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $queryString = 'select * from "books_tests" where ("title" = ? or "category_id" = ?)';
        $data = [
            'filters' => [
                ['column' => 'title', 'operator' => '=', 'value' => 'New Title'],
                ['column' => 'category_id', 'operator' => '=', 'value' => 2, 'boolean' => 'or']
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(2, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function set_query_with_grouped_conditions()
    {
        Book::factory()->create(['title' => 'New Title', 'category_id' => 1]);
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 5]);

        $queryString = 'select * from "books_tests" where "title" = ? and ("category_id" = ? or "category_id" = ?)';
        $data = [
            'filters' => [
                ['column' => 'title', 'operator' => '=', 'value' => 'New Title'],
                [
                    ['column' => 'category_id', 'operator' => '=', 'value' => 1],
                    ['column' => 'category_id', 'operator' => '=', 'value' => 5, 'boolean' => 'or']
                ]
            ]
        ];

        $books = Book::restQl($data)->get();

        $this->assertCount(1, $books);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function sort_ascending_results()
    {
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 5]);

        $queryString = 'select * from "books_tests" order by "category_id" asc';

        $data = [
            'sorts' => [
                ['column' => 'category_id'],
            ]
        ];
        $books = Book::restQl($data)->get();

        $this->assertTrue($books->first()->category_id == 1);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }

    /** @test */
    public function sort_descending_results()
    {
        Book::factory()->create(['category_id' => 2]);
        Book::factory()->create(['category_id' => 1]);
        Book::factory()->create(['category_id' => 4]);
        Book::factory()->create(['category_id' => 3]);
        Book::factory()->create(['category_id' => 5]);

        $queryString = 'select * from "books_tests" order by "category_id" desc';

        $data = [
            'sorts' => [
                ['column' => 'category_id', 'direction' => 'desc'],
            ]
        ];
        $books = Book::restQl($data)->get();

        $this->assertTrue($books->first()->category_id == 5);
        $this->assertEquals($queryString, Book::restQl($data)->toSql());
    }
}
