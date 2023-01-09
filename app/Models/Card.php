<?php

namespace App\Models;

use Str;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['name','description','list_id'];

    protected $appends = ['photo_thumbnail'];

    protected $casts = [
        'done' => 'boolean',
    ];

    public function getPhotoThumbnailAttribute()
    {
        if(!$this->photo)
            return null;
            
        $ext = pathinfo($this->photo, PATHINFO_EXTENSION);

        $name = Str::replaceLast('.'.$ext, '', $this->photo);

        return $name.'-'.'150x150'.'.'.$ext;
    }

    public function toDone()
    {
        $this->done = true;
        return $this;
    }

    public function toUndone()
    {
        $this->done = false;
        return $this;
    }

    public function list()
    {
        return $this->belongsTo(ListModel::class,'list_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
