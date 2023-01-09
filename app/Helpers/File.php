<?php

namespace App\Helpers;

use Str;
use Storage;

class File
{
    public $filesystem;

    public function __construct()
    {
        $this->filesystem = config('filesystems.default');
    }
    
    public function exists($path):bool
    {
        return Storage::disk($this->filesystem)->exists($path) ? true : false;
    }

    public function copy($old_path, $new_path):bool
    {
        return Storage::disk($this->filesystem)->copy($old_path, $new_path) ? true : false;
    }

    public function put($filename,$contants)
    {
       return Storage::disk($this->filesystem)->put($filename, $contants);
    }
    public function putFileAs($directory,$contants,$name)
    {
       return Storage::disk($this->filesystem)->putFileAs($directory, $contants,$name);
    }
    public function path($name)
    {
        return Storage::disk($this->filesystem)->url($name);
    }
    public function storageRoot()
    {
        return str_replace('//','/',Storage::disk($this->filesystem)->path('/'));
    }

}