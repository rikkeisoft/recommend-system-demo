<?php

namespace App\Http\Controllers;

use App\Model\Book;
use App\Model\Rate;
use App\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    /**
     * Book list
     *
     * @param Request $request
     *
     * @return type
     */
    public function index(Request $request)
    {
        // RECOMMENDATION
        $userRateAvg = $this->__getUserRateAvg();

        if ($userRateAvg) {
            $recommended = $this->__recommendedForUser(null, $userRateAvg);
        } else {
            $recommended = $this->__recommendedForGuest();
        }

        $authors = Book::groupBy('author')->get();

        foreach ($authors as $author) {
            $author->listBooks = Book::where('author', $author->author)->get();
        }

        return view('books.index', [
            'recommendBooks' => $recommended,
            'authors'        => $authors,
        ]);
    }

    /**
     * View book detail
     *
     * @param Request $request Request
     * @param Book    $book    Book object
     *
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

        // RECOMMENDATION
        $userRateAvg = $this->__getUserRateAvg();

        if ($userRateAvg) {
            $recommended = $this->__recommendedForUser($book, $userRateAvg);
        } else {
            $recommended = $this->__recommendedForGuest($book);
        }

        return view('books.show', [
            'recommendBooks' => $recommended,
            'book'           => $book,
            'rate_avg'       => $rate_avg,
        ]);
    }

    /**
     * Get list book by category
     *
     * @param Request  $request
     * @param Category $category
     *
     * @return type
     */
    public function getListBookByCategory(Request $request, Category $category)
    {
        $authors = $category->books()->groupBy('author')->get();

        foreach ($authors as $author) {
            $author->listBooks = Book::where('author', $author->author)->get();
        }

        return view('books.books_by_category', [
            'category' => $category,
            'authors'  => $authors,
        ]);
    }

    /**
     * Search book
     *
     * @param Request $request
     *
     * @return type
     */
    public function search(Request $request)
    {
        $books = Book::where('title', 'LIKE', '%' . $request->search_query . '%')
            ->orWhere('description', 'LIKE', '%' . $request->search_query . '%')
            ->orWhere('author', 'LIKE', '%' . $request->search_query . '%')
            ->get();

        return view('books.search', [
            'books'        => $books,
            'search_query' => $request->search_query,
        ]);
    }

    /**
     * When user rate book
     *
     * @param Request $request
     * @param Book    $book
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

    /**
     * Check user interact with system or not
     *
     * @return bool
     */
    private function __getUserRateAvg()
    {
        if (auth()->check()) {
            $userRateAvg = Rate::select(DB::raw('AVG(point) as rate_avg'))
                ->where('user_id', auth()->user()->id)
                ->first();

            if ($userRateAvg->rate_avg) {
                return $userRateAvg->rate_avg;
            }

            return 0;
        }

        return 0;
    }

    /**
     * Get top 10 books have most views or rates
     *
     * @param Book $bookDetail The book is showing => get top 10 books have the same properties with the book
     *
     * @return Array
     */

    private function __recommendedForGuest($bookDetail = null)
    {
        // Get top 10 books have most rates
        $topRates = Book::select('books.*', DB::raw('AVG(rates.point) as rate_avg'))
            ->join('rates', 'books.id', '=', 'rates.book_id');

        if (!is_null($bookDetail)) {
            $topRates = $topRates->where('author', 'LIKE', '%' . $bookDetail->author . '%')
                ->orWhere('category_id', '=', $bookDetail->category_id);
        }

        $topRates = $topRates->groupBy('books.id')
            ->orderBy('rate_avg', 'DESC')
            ->limit(10)
            ->get();

        // Get top 10 books have most views
        $topRatesIds = $topRates->pluck('id')->toArray();

        $topViews = Book::whereNotIn('id', $topRatesIds);

        if (!is_null($bookDetail)) {
            $topViews = $topRates->where('books.id', '<>', $bookDetail->id)
                ->where(function ($query) use ($bookDetail) {
                    $query->where('author', 'LIKE', '%' . $bookDetail->author . '%')
                        ->orWhere('category_id', '=', $bookDetail->category_id);
                });
        }

        $topViews = $topViews->orderBy('views')
            ->limit(10)
            ->get();

        // Merge top 10 rates with top 10 views => return 10 books random
        $recommended = $topRates->merge($topViews);

        return (count($recommended) > 10)
            ? $recommended->random(10) : $recommended;
    }

    /**
     * Get top 10 books have most views or rates when user logged
     *
     * @param Book  $bookDetail  The book is showing => get top 10 books have the same properties with the book
     * @param Float $userRateAvg User rate avg
     *
     * @return Array
     */
    private function __recommendedForUser($bookDetail = null, $userRateAvg)
    {
        $authId = auth()->user()->id;

        // Get top 10 books have most rates by Auth
        $topBooksVotedByAuth = Book::select('books.*', DB::raw('AVG(rates.point) as rate_avg'))
            ->join('rates', 'books.id', '=', 'rates.book_id')
            ->where('rates.user_id', '=', $authId)
            ->groupBy('books.id')
            ->orderBy('rate_avg', 'DESC')
            ->having('rate_avg', '>=', $userRateAvg)
            ->limit(10)
            ->get();

        // List Books Id of Auth interact
        $listBooksIdVotedByAuth = $topBooksVotedByAuth->pluck('id')->toArray();

        // Get list another users id interact with $topBooksVotedByAuth
        $listAnotherUsersId = Rate::whereIn('book_id', $listBooksIdVotedByAuth)
            ->distinct('user_id')
            ->pluck('user_id')
            ->toArray();

        // Get top 10 books have most rates suggest for Auth
        $topRates = Book::select('books.*', DB::raw('AVG(rates.point) as rate_avg'))
            ->join('rates', 'books.id', '=', 'rates.book_id')
            ->whereIn('rates.user_id', $listAnotherUsersId);

        if (!is_null($bookDetail)) {
            $topRates = $topRates->where('books.id', '<>', $bookDetail->id)
                ->where(function ($query) use ($bookDetail) {
                    $query->where('author', 'LIKE', '%' . $bookDetail->author . '%')
                        ->orWhere('category_id', '=', $bookDetail->category_id);
                });
        }

        $topRates = $topRates->groupBy('books.id')
            ->where('rates.point', '>=', $userRateAvg)
            ->orderBy('rate_avg', 'DESC')
            ->limit(10)
            ->get();

        // Get top 10 books have most views by Auth
        $topRatesIds = $topRates->pluck('id')->toArray();

        $topViews = Book::select('books.*')
            ->join('rates', 'books.id', '=', 'rates.book_id')
            ->whereNotIn('books.id', $topRatesIds)
            ->whereIn('rates.user_id', $listAnotherUsersId);

        if (!is_null($bookDetail)) {
            $topViews = $topViews->where('author', 'LIKE', '%' . $bookDetail->author . '%')
                ->orWhere('category_id', '=', $bookDetail->category_id);
        }

        $topViews = $topViews->orderBy('views')
            ->limit(10)
            ->get();

        // Merge top 10 rates with top 10 views => return 10 books random
        $recommended = $topRates->merge($topViews);

        return (count($recommended) > 10)
            ? $recommended->random(10) : $recommended;
    }
}
