<?php

namespace App\Http\Controllers\Ajax\Todo;

use DB;
use Exception;
use Validator;

use App\Models\{Board,User};
use App\Http\Controllers\Controller;
use App\Http\Requests\{AddUserRequest,ChangeRequest};


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
    public function permissions(Request $request,$id)
    {
        try {

            $board = Board::select('id','name')->with(['guests'=>function($q){$q->select('users.id','email');}])->find($id);

           
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
    public function addGuest(AddUserRequest $request,$id)
    {
        try {

            $board = Board::find($id);

            $user = User::where('email',$request->email)->first();

            $board->guests()->sync($user->id);

            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => ajax_error_message($e->getMessage())
            ], 200);
        }
    }
    
    public function deleteGuest(Request $request,$id,$guest)
    {
        try {

            $board = Board::find($id);

            $board->guests()->detach($guest);

            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => ajax_error_message($e->getMessage())
            ], 200);
        }
    }
    public function change(ChangeRequest $request,$id,$guest)
    {
        try {

            $board = Board::find($id);

            $board->guests()->syncWithPivotValues($guest,[$request->permission=>$request->status]);

            return response()->json([
                'status' => 'success',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => ajax_error_message($e->getMessage())
            ], 200);
        }
    }
   
}
