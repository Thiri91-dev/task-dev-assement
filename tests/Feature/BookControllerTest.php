<?php
namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_updates_book_successfully()
    {
        $book = Book::create([
            'title' => 'The Catcher in the Rye',
            'author' => 'J.D. Salinger',
            'rating' => 5,
        ]);

        $updatedData = [
            'title' => 'The Catcher in the Rye (Updated Edition)',
            'author' => 'J.D. Salinger',
            'rating' => 4,
        ];

        $response = $this->putJson(route('books.update', $book->id), $updatedData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully updated the book.',
                'data' => $updatedData
            ]);

        $this->assertDatabaseHas('books', $updatedData + ['id' => $book->id]);
    }

    /** @test */
    public function it_returns_404_for_nonexistent_book()
    {
        Log::spy();
        $updatedData = [
            'title' => 'Non-existing Book Title',
            'author' => 'Unknown Author',
            'rating' => 3,
        ];

        $response = $this->putJson(route('books.update', 999), $updatedData);

        $response->assertStatus(404)
            ->assertJson(['error' => 'Book not found']);

        Log::shouldHaveReceived('error')->once()->with('Book not found!');

    }

    /** @test */
    public function it_validates_missing_data()
    {
        $book = Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'rating' => 4,
        ]);

        $updatedData = [
            'author' => 'George Orwell',
            'rating' => 5,
        ];

        $response = $this->putJson(route('books.update', $book->id), $updatedData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    /** @test */
    public function it_logs_before_update()
    {

        $book = Book::create([
            'title' => 'To Kill a Mockingbird',
            'author' => 'Harper Lee',
            'rating' => 4,
        ]);

        $updatedData = [
            'title' => 'To Kill a Mockingbird (Anniversary Edition)',
            'author' => 'Harper Lee',
            'rating' => 5,
        ];

        Log::shouldReceive('info')
            ->once()
            ->with('Book before update:', \Mockery::on(function ($arg) use ($book) {
                return $arg['id'] === $book->id && $arg['title'] === 'To Kill a Mockingbird';
            }));

        $response = $this->putJson(route('books.update', $book->id), $updatedData);

        $response->assertStatus(200);
    }
}
