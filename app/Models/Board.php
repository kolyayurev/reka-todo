<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['name','user_id'];


    public function scopeByUser($query)
    {
        return $query->where('user_id', auth()->id());
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lists()
    {
        return $this->hasMany(ListModel::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
    
    public function guests()
    {
        return $this->belongsToMany(User::class,'board_user')
        ->using(Permission::class)
        ->withPivot('read','write');
    }
}
