<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Model\Book;
use App\Model\Rate;
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
            'authors'        => $authors,
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

        $rate_avg = auth()->check() ?
                $book->rates()->where('user_id', auth()->user()->id)
                        ->avg('point') : 0;

        return view('books.show', [
            'recommendBooks' => $this->_recommendBooks,
            'book'           => $book,
            'rate_avg'       => $rate_avg,
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

    /**
     * When user rate book
     * 
     * @param Request $request
     * @param Book $book
     * 
     * @return Response
     */
    public function rate(Request $request, Book $book)
    {
        $isRate = $book->rates()->where('user_id', auth()->user()->id)
                ->where('book_id', $book->id)
                ->first();

        if (count($isRate)) {
            $isRate->update(['point' => $request->point]);
        } else {
            Rate::create([
                'user_id' => auth()->user()->id,
                'book_id' => $book->id,
                'point'   => $request->point,
            ]);
        }

        return response()->json([
                    'status'   => 1,
                    'rate_avg' => $book->rates()->avg('point'),
        ]);
    }

}
