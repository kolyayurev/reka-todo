<?php
namespace App\Repositories;

use App\Models\Board;

class BoardRepository extends BaseRepository
{

    public function model()
    {
        return app(Board::class);
    }

    public function getForShow($id,$select = ['*'])
    {
       return  $this->query->select($select)
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
    }
    public function getPermissions($id,$select = ['*'])
    {
        return $this->query->select($select)->with(['guests'=>function($q){$q->select('users.id','email');}])->find($id);
    }

}
