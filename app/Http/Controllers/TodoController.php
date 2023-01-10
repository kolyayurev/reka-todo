<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Repositories\UserRepository;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        private UserRepository $userRepository
    )
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $boards = $this->userRepository->getMyBoard();

        $guestBoards = $this->userRepository->getGuestBoard();

        return view('todo.index',compact('boards','guestBoards'));
    }

    public function board($id)
    {
        
        $board = Board::findOrFail($id);

        if (!Gate::allows('read-board', $board)) {
            abort(403);
        }

        return view('todo.board',compact('board'));
    }
    public function permissions($id)
    {
        $board = Board::findOrFail($id);

        return view('todo.permissions',compact('board'));
    }
}
