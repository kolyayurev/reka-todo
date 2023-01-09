<?php

namespace App\Http\Controllers;

use App\Models\Board;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $boards = Board::byUser()->get();
        return view('todo.index',compact('boards'));
    }

    public function board($id)
    {
        return view('todo.board');
    }
}
