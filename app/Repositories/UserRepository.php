<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{

    public function model()
    {
        return app(User::class);
    }

    public function getMyBoard($select = ['*'])
    {
        return auth()->user()->boards()->get();
    }

    public function getGuestBoard($select = ['*'])
    {
        return auth()->user()->guestBoards()->where(['read'=>true])->with(['user'=>function($q){$q->select('id','email');}])->get();
    }


}
