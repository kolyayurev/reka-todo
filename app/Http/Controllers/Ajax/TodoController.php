<?php

namespace App\Http\Controllers\Ajax;

use DB;
use Exception;
use Validator;

use App\Models\{Board,Card};
use App\Http\Controllers\Controller;
use App\Http\Requests\CardRequest;

// use Facades\App\Helpers\File;

use Illuminate\Http\Request;

class TodoController extends Controller
{
   
    public function board(Request $request)
    {
        $board = Board::select('id','name')
                        ->with(['lists'=>function($q){
                            $q->select('id','name','board_id')
                            ->with(['cards'=>function($q){
                                $q->select('id','name','description','done','photo','list_id');
                            }]);
                        }])
                        ->first();

        return response()->json([
            'status' => 'success',
            'board' => $board,
        ], 200);
    }

    public function cardStore(CardRequest $request)
    {
        try {

            $card = Card::create($request->all());

            return response()->json([
                'status' => 'success',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => ajax_error_message($e->getMessage())
            ], 200);
        }
    }
    public function cardDelete($id)
    {
        try {
            // TODO: Проверять пренадлежность к владельцу
            Card::destroy($id);

            return response()->json([
                'status' => 'success',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => ajax_error_message($e->getMessage())
            ], 200);
        }
    }
    /*
    public function cardStore(CardRequest $request)
    {
        try {
            
            
            DB::transaction(function()  use($request){

                $mistake = Mistake::create($request->all());
                
                if ($request->hasFile('file')) {

                    $file = $request->file('file');
                
                    $filename = time().$file->hashName();

                    $directory =  str_replace('//','/',$mistake->getPhotosDirectory().'/'.$mistake->id);

                    $path = File::put($directory,$file,$filename);

                    $mistake->file = $path;

                    $mistake->update();
                }
            });

            return response()->json([
                'status' => 'success',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'msg' => ajax_error_message($e->getMessage())
            ], 200);
        }
    }
    */

   
   
}
