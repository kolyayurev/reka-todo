<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['name','description','photo','list_id'];

    public function list()
    {
        return $this->belongsTo(ListModel::class,'list_id');
    }
}
