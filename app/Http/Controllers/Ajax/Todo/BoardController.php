<?php

namespace App\Http\Controllers\Ajax\Todo;

use DB;
use Exception;
use Validator;

use App\Models\{Board};
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class BoardController extends Controller
{
   
    public function show(Request $request,$id)
    {
        try {

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
                            ->find($id);

            return response()->json([
                'status' => 'success',
                'board' => $board,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => ajax_error_message($e->getMessage())
            ], 200);
        }
    }

   
}
