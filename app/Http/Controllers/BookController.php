<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class BookController extends Controller
{

    /**
     * Book list
     *
     * @param Request $request
     * @return type
     */
    public function index(Request $request)
    {
        return view('books.index');
    }

    /**
     * View book detail
     *
     * @param Request $request
     * @return type
     */
    public function show(Request $request)
    {
        return view('books.show');
    }

    /**
     * Search book
     *
     * @param Request $request
     * @return type
     */
    public function search(Request $request)
    {
        return view('books.search');
    }
}
