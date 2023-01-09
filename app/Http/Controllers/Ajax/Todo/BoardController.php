<?php

namespace App\Http\Controllers\Ajax\Todo;

use DB;
use Exception;
use Validator;

use App\Models\{Board,Card};
use App\Http\Controllers\Controller;
use App\Http\Requests\CardRequest;

// use Facades\App\Helpers\File;

use Illuminate\Http\Request;

class BoardController extends Controller
{
   
    public function board(Request $request)
    {
        $board = Board::select('id','name')
                        ->with(
                            ['lists'=>function($q){
                                $q->select('id','name','board_id')
                                ->with(['cards'=>function($q){
                                    $q->select('id','name','description','done','photo','list_id')
                                    ->with(['tags'=>function($q){$q->select('tags.id','name','board_id');}]);
                                }]);
                            },
                            'tags'=>function($q){ $q->select('id','name','board_id'); }
                            ]
                        )
                        ->first();

        return response()->json([
            'status' => 'success',
            'board' => $board,
        ], 200);
    }

   
}
