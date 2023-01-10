<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Relations\Pivot ;

class Permission extends Pivot
{
    protected $table = 'board_user';


    protected $casts = [
        'read' => 'boolean',
        'write' => 'boolean',
    ];
   
}
