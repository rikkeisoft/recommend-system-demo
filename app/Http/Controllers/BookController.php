<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Model\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    /**
     * Construct
     */
    public function __construct()
    {
        $this->_recommendBooks = Book::all()->random(10);
    }

    /**
     * Book list
     *
     * @param Request $request
     * @return type
     */
    public function index(Request $request)
    {
        $authors = Book::groupBy('author')->get();

        foreach ($authors as $author) {
            $author->listBooks = Book::where('author', $author->author)->get();
        }

        return view('books.index', [
            'recommendBooks' => $this->_recommendBooks,
            'authors' => $authors,
        ]);
    }

    /**
     * View book detail
     *
     * @param Request $request
     * @return type
     */
    public function show(Request $request, Book $book)
    {
        $book->update([
            'views' => $book->views + 1,
        ]);

        return view('books.show', [
            'recommendBooks' => $this->_recommendBooks,
            'book' => $book,
        ]);
    }

    /**
     * Search book
     *
     * @param Request $request
     * @return type
     */
    public function search(Request $request)
    {
        $books = Book::where('title', 'LIKE', '%' . $request->search_query . '%')
            ->orWhere('description', 'LIKE', '%' . $request->search_query . '%')
            ->orWhere('author', 'LIKE', '%' . $request->search_query . '%')
            ->get();

        return view('books.search', [
            'books' => $books,
        ]);
    }
}
