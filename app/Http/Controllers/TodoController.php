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
        $guestBoards = auth()->user()->guestBoards()->with(['user'=>function($q){$q->select('id','email');}])->get();

        return view('todo.index',compact('boards','guestBoards'));
    }

    public function board($id)
    {
        $board = Board::findOrFail($id);

        return view('todo.board',compact('board'));
    }
    public function permissions($id)
    {
        $board = Board::findOrFail($id);

        return view('todo.permissions',compact('board'));
    }
}
