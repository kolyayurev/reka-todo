<?php

namespace App\Http\Controllers\Ajax\Todo;

use DB;
use Str;
use Exception;

use App\Models\{Card,Tag};
use App\Http\Controllers\Controller;
use App\Http\Requests\CardRequest;

use Facades\App\Helpers\File;

use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;

class CardController extends Controller
{
   
    protected function upload($request,$field,$model) : string | null
    {
        if ($request->hasFile($field)) {

            $file = $request->file($field);
            $extension = $file->getClientOriginalExtension();

            $directory =  'cards/'.$model->id.'/';

            $name = Str::replaceLast('.'.$extension, '', $file->hashName());

            $filename = $name.'.'.$extension;

            $path = File::putFileAs($directory,$file,$filename);

            $thumbnail_filename = $name.'-150x150.'.$extension;

            $thumbnail = Image::make($file)->fit(150,150,function ($constraint) {
                $constraint->aspectRatio();
            });

            File::put($directory.$thumbnail_filename, $thumbnail->encode($extension)->encoded);

            return $path;
            
        }

        return is_string($request->{$field})? $request->{$field}: null;
    }

    
    public function store(CardRequest $request)
    {
        try {
            DB::transaction(function()  use($request){

                $card = Card::create($request->all());

                $path = $this->upload($request,'photo',$card);

                $card->photo = $path;

                $card->update();

                $this->saveTags($request->tags,$card);

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
    public function update(CardRequest $request,$id)
    {
        try {

            DB::transaction(function()  use($request,$id){

                $card = Card::find($id);
                $card->name = $request->name;
                $card->list_id = $request->list_id;
                $card->update();

                $path = $this->upload($request,'photo',$card);

                $card->photo = $path;

                $card->update();

                $this->saveTags($request->tags,$card);
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
    protected function saveTags( $tags, &$card)
    {

        $tags = json_decode($tags,true);
        if(!is_array($tags))
            return;

        $tagIds = [];
        foreach ($tags as $item) {
            $item = array_intersect_key($item, array_flip(['id','name','board_id']));
            $tag = Tag::firstOrCreate($item);
            array_push($tagIds,$tag->id);
        }
        $card->tags()->sync($tagIds);
    }
    public function done(int $id)
    {
        try {

            $card = Card::find($id);
           
            $card->toDone()->save();

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

    public function undone(int $id)
    {
        try {

            $card = Card::find($id);
           
            $card->toUndone()->save();
            
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

    public function delete(int $id)
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
   
   
}
